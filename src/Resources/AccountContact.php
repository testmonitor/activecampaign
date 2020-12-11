<?php

namespace TestMonitor\ActiveCampaign\Resources;

class AccountContact extends Resource
{
    /**
     * The id of the account.
     *
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $contact;

    /**
     * @var int
     */
    public $account;

    /**
     * @var string
     */
    public $jobTitle;
}
