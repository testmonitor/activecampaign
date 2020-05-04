<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Automation;
use TestMonitor\ActiveCampaign\Resources\Contact;

trait ManagesContactAutomations
{
    use ImplementsActions;

    /**
     * Get all organizations.
     *
     * @param \TestMonitor\ActiveCampaign\Resources\Contact $contact
     * @param \TestMonitor\ActiveCampaign\Resources\Automation $automation
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
