<?php

namespace TestMonitor\ActiveCampaign\Resources;

class Account extends Resource
{
    /**
     * The id of the account.
     *
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $accountUrl;

    /**
     * List of custom fields.
     *
     * @var array
     */
    public $fields;
}
