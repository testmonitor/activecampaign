<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Contact;
use ByTestGear\ActiveCampaign\Resources\Automation;

trait Contacts
{
    /**
     * Get all contacts.
     *
     * @return array
     */
    public function contacts($email = null)
    {
        return $this->transformCollection(
            $this->get('contacts', ['query' => ['email' => $email]]),
            Contact::class,
            'contacts'
        );
    }

    /**
     * Create new contact.
     *
     * @return \Illuminate\Support\Collection
     */
    public function createContact(array $data = [])
    {
        return $this->post('contacts', ['json' => ['contact' => $data]]);
    }

    /**
     * Get all automations of a contact.
     *
     * @return array
     */
    public function contactAutomations(Contact $contact)
    {
        return $this->transformCollection(
            $this->get("contacts/{$contact->id}/contactAutomations"),
            \ByTestGear\ActiveCampaign\Resources\ContactAutomation::class,
            'contactAutomations'
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
        $removeAutomation = null;

        foreach ($contactAutomations as $contactAutomation) {
            if ($contactAutomation->automation == $automation->id) {
                $removeAutomation = $contactAutomation;
            }
        }

        if (empty($removeAutomation)) {
            return;
        }

        return $this->delete("contactAutomations/{$removeAutomation->id}");
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
}
