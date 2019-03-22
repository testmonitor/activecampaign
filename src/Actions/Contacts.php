<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Contact;

trait Contacts
{
    /**
     * Get all organizations.
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
     * Create new organization.
     *
     * @return \Illuminate\Support\Collection
     */
    public function createContact(array $data = [])
    {
        return $this->post('contacts', ['json' => ['contact' => $data]]);
    }
}
