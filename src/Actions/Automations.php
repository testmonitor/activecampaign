<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Automation;

trait Automations
{
    /**
     * Get all automations.
     *
     * @return array
     */
    public function automations($query = null)
    {
        return $this->transformCollection(
            $this->get('automations', ['query' => ['search' => $query]]),
            Automation::class,
            'automations'
        );
    }
}
