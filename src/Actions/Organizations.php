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
    public function organizations()
    {
        return $this->transformCollection(
            $this->get('organizations'),
            Organization::class,
            'organizations'
        );
    }

    /**
     * Find organization by name.
     *
     * @return array
     */
    public function findOrganization($query = null)
    {
        $organizations = $this->transformCollection(
            $this->get('organizations', ['query' => ['filters[name]' => $query]]),
            Organization::class,
            'organizations'
        );

        return array_pop($organizations);
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

    /**
     * Find or create an organization.
     *
     * @param $name
     *
     * @return mixed
     */
    public function findOrCreateOrganization($name)
    {
        $organization = $this->findOrganization($name);

        if (empty($organization)) {
            $this->createOrganization(['name' => $name]);

            return $this->findOrganization($name);
        }

        return $organization;
    }
}
