<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Organization;

trait ManagesOrganizations
{
    use ImplementsActions;

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
     * @param string $name
     *
     * @return Organization|null
     */
    public function findOrganization($name)
    {
        $organizations = $this->transformCollection(
            $this->get('organizations', ['query' => ['filters' => ['name' => $name]]]),
            Organization::class,
            'organizations'
        );

        return array_shift($organizations);
    }

    /**
     * Create new organization.
     *
     * @param array $data
     *
     * @return Organization|null
     */
    public function createOrganization(array $data = [])
    {
        $organizations = $this->transformCollection(
            $this->post('organizations', ['json' => ['organization' => $data]]),
            Organization::class
        );

        return array_shift($organizations);
    }

    /**
     * Find or create an organization.
     *
     * @param $name
     *
     * @return Organization
     */
    public function findOrCreateOrganization($name)
    {
        $organization = $this->findOrganization($name);

        if ($organization instanceof Organization) {
            return $organization;
        }

        return $this->createOrganization(['name' => $name]);
    }
}
