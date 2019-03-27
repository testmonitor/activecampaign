<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Tag;
use ByTestGear\ActiveCampaign\Resources\Contact;

trait ContactTags
{
    /**
     * Add .
     *
     * @return array
     */
    public function addTagToContact(Contact $contact, Tag $tag)
    {
        $data = [
            'contact' => $contact->id,
            'tag' => $tag->id,
        ];

        return $this->post('contactTags', ['json' => ['contactTag' => $data]]);
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
            }

            if (is_array($tag)) {
                $this->addTagToContact($contact, $this->findOrCreateTag(array_merge($tag, ['tagType' => 'contact'])));
            }

            if (is_string($tag)) {
                $this->addTagToContact($contact, $this->findOrCreateTag(['name' => $tag, 'tagType' => 'contact']));
            }
        }
    }
}
