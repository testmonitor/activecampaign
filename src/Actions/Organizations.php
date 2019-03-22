<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Organization;

trait Organizations
{
    /**
     * Get all organizations.
     *
     * @return array
     */
    public function organizations($query = null)
    {
        return $this->transformCollection(
            $this->get('organizations', ['query' => ['filters[name]' => $query]]),
            Organization::class,
            'organizations'
        );
    }

    /**
     * Create new organization.
     *
     * @return array
     */
    public function createOrganization(array $data = [])
    {
        return $this->post('organizations', ['json' => ['organization' => $data]]);
    }
}
