<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Tag;
use TestMonitor\ActiveCampaign\Resources\Contact;
use TestMonitor\ActiveCampaign\Resources\Automation;
use TestMonitor\ActiveCampaign\Resources\ContactTag;
use TestMonitor\ActiveCampaign\Resources\ContactAutomation;

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
     * Find contact by ID.
     *
     * @param int $id
     *
     * @return Contact|null
     */
    public function findContactById($id)
    {
        $contact = (object) $this->get('contacts/'.$id);
        return new Contact($contact->contact);
    }

    /**
     * Create new contact.
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param int|null $orgid
     *
     * @return Contact|null
     */
    public function createContact($email, $firstName, $lastName, $orgid = null)
    {
        $contacts = $this->transformCollection(
            $this->post('contacts', ['json' => ['contact' => compact('email', 'firstName', 'lastName', 'orgid')]]),
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
     * @param int|null $orgid
     *
     * @return Contact
     */
    public function findOrCreateContact($email, $firstName, $lastName, $orgid = null)
    {
        $contact = $this->findContact($email);

        if ($contact instanceof Contact) {
            return $contact;
        }

        return $this->createContact($email, $firstName, $lastName, $orgid);
    }

    /**
     * Updates a contact.
     *
     * @param Contact|int|string $id
     * @param string|null        $email
     * @param string|null        $firstName
     * @param string|null        $lastName
     * @param null               $orgid
     *
     * @return Contact|null
     */
    public function updateContact($id, $email, $firstName, $lastName, $orgid = null)
    {
        $id = $this->getContactId($id);

        $this->put('contacts/'.$id, ['json' => ['contact' => compact('email', 'firstName', 'lastName', 'orgid')]]);

        return $this->findContactById($id);
    }

    /**
     * Deletes a contact.
     *
     * @param Contact|int|string $contact
     */
    public function deleteContact($contact)
    {
        $this->delete('contacts/'.$this->getContactId($contact));
    }

    /**
     * Get all automations of a contact.
     *
     * @param \TestMonitor\ActiveCampaign\Resources\Contact $contact
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
     * @param \TestMonitor\ActiveCampaign\Resources\Contact $contact
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
     * @param \TestMonitor\ActiveCampaign\Resources\Contact $contact
     * @param \TestMonitor\ActiveCampaign\Resources\Automation $automation
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
     * @param \TestMonitor\ActiveCampaign\Resources\Contact $contact
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
     * @param \TestMonitor\ActiveCampaign\Resources\Contact $contact
     * @param \TestMonitor\ActiveCampaign\Resources\Tag $tag
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

    /**
     * Determines the contact ID.
     *
     * @param Contact|int|string $contact
     */
    protected function getContactId($contact)
    {
        if ($contact instanceof Contact) {
            return $contact->id;
        } elseif (is_numeric($contact)) {
            return (int) $contact;
        } else {
            $contact = $this->findContact($contact);

            return $contact->id;
        }
    }
}
