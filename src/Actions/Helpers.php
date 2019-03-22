<?php

namespace ByTestGear\ActiveCampaign\Actions;

trait Helpers
{
    /**
     * Find or create an organization.
     *
     * @param $name
     *
     * @return mixed
     */
    public function findOrCreateOrganization($name)
    {
        $organizations = $this->organizations($name);

        if (count($organizations)) {
            $this->createOrganization(['name' => $name]);

            return $this->findOrCreateOrganization($name);
        }

        return array_pop($organizations);
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

    /**
     * Find or create a contact.
     *
     * @param array $details
     *
     * @return mixed
     */
    public function findOrCreateContact(array $details = [])
    {
        $contacts = $this->contacts($details['email']);

        if (count($contacts)) {
            $this->createContact($details);

            return $this->findOrCreateContact($details);
        }

        return array_pop($contacts);
    }
}
