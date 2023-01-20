<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Automation;

trait ManagesAutomations
{
    use ImplementsActions;

    /**
     * Get all automations.
     *
     * @return array
     */
    public function automations()
    {
        return $this->transformCollection(
            $this->get('automations'),
            Automation::class,
            'automations'
        );
    }

    /**
     * Find automation by name.
     *
     * @param string $name
     *
     * @return Automation|null
     */
    public function findAutomation($name)
    {
        $automations = $this->transformCollection(
            $this->get('automations', ['query' => ['search' => $name]]),
            Automation::class,
            'automations'
        );

        return array_shift($automations);
    }
}
