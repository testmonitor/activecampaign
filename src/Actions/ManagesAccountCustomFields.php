<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\AccountCustomField;

trait ManagesAccountCustomFields
{
    use ImplementsActions;

    /**
     * Get all custom fields.
     *
     * @return array
     */
    public function customAccountFields()
    {
        return $this->transformCollection(
            $this->get('accountCustomFieldMeta'),
            AccountCustomField::class,
            'accountCustomFieldMeta'
        );
    }

    /**
     * Find custom field by name.
     *
     * @param string $name
     *
     * @return AccountCustomField|null
     */
    public function findCustomAccountField($name)
    {
        $customFields = $this->transformCollection(
            $this->get('accountCustomFieldMeta', ['query' => ['filters[fieldLabel]' => $name]]),
            AccountCustomField::class,
            'accountCustomFieldMeta'
        );

        return array_shift($customFields);
    }
}
