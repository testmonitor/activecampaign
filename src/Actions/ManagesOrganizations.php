<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Organization;

/** @deprecated use ManageAccounts instead */
trait ManagesOrganizations
{
    use ImplementsActions;

    /**
     * Get all organizations.
     *
     * @param int $limit
     * @param int $offset
     *
     * @deprecated use accounts() instead
     * @return array
     */
    public function organizations(int $limit = 100, int $offset = 0)
    {
        return $this->transformCollection(
            $this->get('organizations', ['query' => ['limit' => $limit, 'offset' => $offset]]),
            Organization::class,
            'organizations'
        );
    }

    /**
     * Find organization by name.
     *
     * @param string $name
     *
     * @deprecated use findAccount() instead
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
     * @deprecated use createAccount() instead
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
     * @deprecated use findOrCreateAccount() instead
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
