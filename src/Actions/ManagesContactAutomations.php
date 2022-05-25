<?php

namespace PerfectWorkout\ActiveCampaign\Actions;

use PerfectWorkout\ActiveCampaign\Resources\Contact;
use PerfectWorkout\ActiveCampaign\Resources\Automation;

trait ManagesContactAutomations
{
    use ImplementsActions;

    /**
     * Get all organizations.
     *
     * @param \PerfectWorkout\ActiveCampaign\Resources\Contact $contact
     * @param \PerfectWorkout\ActiveCampaign\Resources\Automation $automation
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
