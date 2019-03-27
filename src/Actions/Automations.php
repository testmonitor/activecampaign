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

    /**
     * Find or create an automation.
     *
     * @param $name
     *
     * @return bool|mixed
     */
    public function findAutomation($name)
    {
        $automations = $this->automations($name);

        if (count($automations)) {
            return false;
        }

        return array_pop($automations);
    }
}
