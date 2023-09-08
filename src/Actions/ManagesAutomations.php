<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Automation;

trait ManagesAutomations
{
    use ImplementsActions;

    /**
     * Get all automations.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function automations(int $limit = 100, int $offset = 0)
    {
        return $this->transformCollection(
            $this->get('automations', ['query' => ['limit' => $limit, 'offset' => $offset]]),
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
