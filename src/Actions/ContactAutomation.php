<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Contact;
use ByTestGear\ActiveCampaign\Resources\Automation;

trait ContactAutomation
{
    /**
     * Get all organizations.
     *
     * @return array
     */
    public function addContactToAutomation(Contact $contact, Automation $automation)
    {
        $data = [
            'contact' => $contact->id,
            'automation' => $automation->id,
        ];

        return $this->post('contactAutomations', ['json' => ['contactAutomation' => $data]]);
    }
}
