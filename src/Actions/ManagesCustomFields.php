<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Contact;
use TestMonitor\ActiveCampaign\Resources\CustomField;

trait ManagesCustomFields
{
    use ImplementsActions;

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
     * Find custom field by name.
     *
     * @param string $name
     *
     * @return CustomField|null
     */
    public function findCustomField($name)
    {
        $customFields = $this->transformCollection(
            $this->get('fields', ['query' => ['search' => $name]]),
            CustomField::class,
            'fields'
        );

        return array_shift($customFields);
    }

    /**
     * Add custom field value to contact.
     *
     * @param \TestMonitor\ActiveCampaign\Resources\Contact $contact
     * @param \TestMonitor\ActiveCampaign\Resources\CustomField $customField
     * @param $value
     *
     * @return Contact
     */
    public function addCustomFieldToContact(Contact $contact, CustomField $customField, $value)
    {
        $data = [
            'contact' => $contact->id,
            'field' => $customField->id,
            'value' => $value,
        ];

        $contacts = $this->transformCollection(
            $this->post('fieldValues', ['json' => ['fieldValue' => $data]]),
            Contact::class,
            'contacts'
        );

        return array_shift($contacts);
    }
}
