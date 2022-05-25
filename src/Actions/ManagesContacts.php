<?php

namespace PerfectWorkout\ActiveCampaign\Actions;

use PerfectWorkout\ActiveCampaign\Resources\Tag;
use PerfectWorkout\ActiveCampaign\Resources\Contact;
use PerfectWorkout\ActiveCampaign\Resources\Automation;
use PerfectWorkout\ActiveCampaign\Resources\ContactTag;
use PerfectWorkout\ActiveCampaign\Resources\ContactAutomation;

trait ManagesContacts
{
    use ImplementsActions;

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
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param int|null $phone
     *
     * @return Contact|null
     */
    public function createContact(string $email, string $firstName, string $lastName, ?string $phone = null, array $fieldValues = [])
    {
        $contacts = $this->transformCollection(
            $this->post('contacts', [
                'json' => [
                    'contact' => [
                        'email' => $email,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'phone' => $phone,
                        'fieldValues' => $fieldValues
                    ]
                ]
            ]),
            Contact::class
        );

        return array_shift($contacts);
    }

    public function updateContact(int $id, string $email, string $firstName, string $lastName, ?string $phone, array $fieldValues = [])
    {
        $contacts = $this->transformCollection(
            $this->put('contacts/' . $id, [
                'json' => [
                    'contact' => [
                        'email' => $email,
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'phone' => $phone,
                        'fieldValues' => $fieldValues
                    ]
                ]
            ]),
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
     * @param string $phone
     *
     * @return Contact
     */
    public function findOrCreateContact($email, $firstName, $lastName, $phone)
    {
        $contact = $this->findContact($email);

        if ($contact instanceof Contact) {
            return $contact;
        }

        return $this->createContact($email, $firstName, $lastName, $phone);
    }

    /**
     * Update or create an account.
     *
     * @param string $name
     * @param array $data
     *
     * @return Contact
     */
    public function updateOrCreateContact($email, $firstName, $lastName, $phone)
    {
        $contacts = $this->transformCollection(
            $this->post('contact/sync', ['json' => ['contact' => compact('email', 'firstName', 'lastName', 'phone')]]),
            Contact::class
        );

        return array_shift($contacts);
    }

    /**
     * Get all automations of a contact.
     *
     * @param \PerfectWorkout\ActiveCampaign\Resources\Contact $contact
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
     * @param \PerfectWorkout\ActiveCampaign\Resources\Contact $contact
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
     * @param \PerfectWorkout\ActiveCampaign\Resources\Contact $contact
     * @param \PerfectWorkout\ActiveCampaign\Resources\Automation $automation
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
     * @param \PerfectWorkout\ActiveCampaign\Resources\Contact $contact
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
     * @param \PerfectWorkout\ActiveCampaign\Resources\Contact $contact
     * @param \PerfectWorkout\ActiveCampaign\Resources\Tag $tag
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
