<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Tag;
use ByTestGear\ActiveCampaign\Resources\Contact;
use ByTestGear\ActiveCampaign\Resources\Automation;
use ByTestGear\ActiveCampaign\Resources\ContactTag;
use ByTestGear\ActiveCampaign\Resources\ContactAutomation;

trait ManagesContacts
{
    /**
     * Get all contacts.
     *
     * @return array
     */
    public function contacts()
    {
        return $this->transformCollection(
            $this->get('contacts'),
            Contact::class,
            'contacts'
        );
    }

    /**
     * Find contact by email.
     *
     * @param string $email
     *
     * @return Contact|null
     */
    public function findContact($email)
    {
        $contacts = $this->transformCollection(
            $this->get('contacts', ['query' => ['email' => $email]]),
            Contact::class,
            'contacts'
        );

        return array_shift($contacts);
    }

    /**
     * Create new contact.
     *
     * @param array $data
     *
     * @return Contact|null
     */
    public function createContact(array $data = [])
    {
        $contacts = $this->transformCollection(
            $this->post('contacts', ['json' => ['contact' => $data]]),
            Contact::class
        );

        return array_shift($contacts);
    }

    /**
     * Find or create a contact.
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param int $orgid
     *
     * @return Contact
     */
    public function findOrCreateContact($email, $firstName, $lastName, $orgid)
    {
        $contact = $this->findContact($email);

        if ($contact instanceof Contact) {
            return $contact;
        }

        return $this->createContact(compact('email', 'firstName', 'lastName', 'orgid'));
    }

    /**
     * Get all automations of a contact.
     *
     * @param \ByTestGear\ActiveCampaign\Resources\Contact $contact
     *
     * @return array
     */
    public function contactAutomations(Contact $contact)
    {
        return $this->transformCollection(
            $this->get("contacts/{$contact->id}/contactAutomations"),
            ContactAutomation::class,
            'contactAutomations'
        );
    }

    /**
     * Get all tags of a contact.
     *
     * @param \ByTestGear\ActiveCampaign\Resources\Contact $contact
     *
     * @return array
     */
    public function contactTags(Contact $contact)
    {
        return $this->transformCollection(
            $this->get("contacts/{$contact->id}/contactTags"),
            ContactTag::class,
            'contactTags'
        );
    }

    /**
     * Removing a automation from a contact.
     *
     * @param \ByTestGear\ActiveCampaign\Resources\Contact $contact
     * @param \ByTestGear\ActiveCampaign\Resources\Automation $automation
     */
    public function removeAutomationFromContact(Contact $contact, Automation $automation)
    {
        $contactAutomations = $this->contactAutomations($contact);

        $contactAutomation = current(array_filter($contactAutomations, function ($contactAutomation) use ($automation) {
            return $contactAutomation->automation == $automation->id;
        }));

        if (empty($contactAutomation)) {
            return;
        }

        $this->delete("contactAutomations/{$contactAutomation->id}");
    }

    /**
     * Removing all automations from a contact.
     *
     * @param \ByTestGear\ActiveCampaign\Resources\Contact $contact
     */
    public function removeAllAutomationsFromContact(Contact $contact)
    {
        $contactAutomations = $this->contactAutomations($contact);

        foreach ($contactAutomations as $contactAutomation) {
            $this->delete("contactAutomations/{$contactAutomation->id}");
        }
    }

    /**
     * Removing a tag from a contact.
     *
     * @param \ByTestGear\ActiveCampaign\Resources\Contact $contact
     * @param \ByTestGear\ActiveCampaign\Resources\Tag $tag
     */
    public function removeTagFromContact(Contact $contact, Tag $tag)
    {
        $contactTags = $this->contactTags($contact);

        $contactTag = current(array_filter($contactTags, function ($contactTag) use ($tag) {
            return $contactTag->tag == $tag->id;
        }));

        if (empty($contactTag)) {
            return;
        }

        $this->delete("contactTags/{$contactTag->id}");
    }
}
