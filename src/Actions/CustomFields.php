<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Contact;
use ByTestGear\ActiveCampaign\Resources\CustomField;

trait CustomFields
{
    /**
     * Get all custom fields.
     *
     * @return array
     */
    public function customFields()
    {
        return $this->transformCollection(
            $this->get('fields'),
            CustomField::class,
            'fields'
        );
    }

    /**
     * Get all organizations.
     *
     * @return array
     */
    public function findCustomField($query = null)
    {
        $customFields =  $this->transformCollection(
            $this->get('fields', ['query' => ['search' => $query]]),
            CustomField::class,
            'fields'
        );

        return array_pop($customFields);
    }

    /**
     * Get all organizations.
     *
     * @return \Illuminate\Support\Collection
     */
    public function addCustomFieldToContact(Contact $contact, CustomField $customField, $value)
    {
        $data = [
            'contact' => $contact->id,
            'field' => $customField->id,
            'value' => $value,
        ];

        return $this->post('fieldValues', ['json' => ['fieldValue' => $data]]);
    }
}
