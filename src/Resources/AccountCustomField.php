<?php

namespace TestMonitor\ActiveCampaign\Resources;

class AccountCustomField extends Resource
{
    /**
     * The id of the custom field.
     *
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $fieldLabel;

    /**
     * @var string
     */
    public $fieldType;

    /**
     * @var string
     */
    public $fieldDefault;

    /**
     * @var array
     */
    public $fieldOptions;

    /**
     * @var bool
     */
    public $isFormVisible;

    /**
     * @var bool
     */
    public $isRequired;

    /**
     * @var bool
     */
    public $displayOrder;
}
