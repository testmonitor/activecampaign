<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Tag;
use ByTestGear\ActiveCampaign\Resources\Contact;

trait ManagesContactTags
{
    /**
     * Add tag to contact.
     *
     * @param \ByTestGear\ActiveCampaign\Resources\Contact $contact
     * @param \ByTestGear\ActiveCampaign\Resources\Tag $tag
     *
     * @return array
     */
    public function addTagToContact(Contact $contact, Tag $tag)
    {
        $data = [
            'contact' => $contact->id,
            'tag' => $tag->id,
        ];

        return $this->transformCollection(
            $this->post('contactTags', ['json' => ['contactTag' => $data]]),
            Tag::class
        );
    }

    /**
     * @param \ByTestGear\ActiveCampaign\Resources\Contact $contact
     * @param array $tags
     */
    public function addTagsToContact(Contact $contact, array $tags)
    {
        foreach ($tags as $tag) {
            if ($tag instanceof Tag) {
                $this->addTagToContact($contact, $tag);
            } elseif (is_string($tag)) {
                $this->addTagToContact($contact, $this->findOrCreateTag($tag));
            }
        }
    }
}
