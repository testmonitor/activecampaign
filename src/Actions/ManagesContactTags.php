<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Contact;
use TestMonitor\ActiveCampaign\Resources\Tag;

trait ManagesContactTags
{
    use ImplementsActions;

    /**
     * Add tag to contact.
     *
     * @param \TestMonitor\ActiveCampaign\Resources\Contact $contact
     * @param \TestMonitor\ActiveCampaign\Resources\Tag $tag
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
     * @param \TestMonitor\ActiveCampaign\Resources\Contact $contact
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
