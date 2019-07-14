<?php

namespace TestMonitor\ActiveCampaign\Resources;

class ContactAutomation extends Resource
{
    /**
     * The id of the contact automation.
     *
     * @var int
     */
    public $id;

    /**
     * Contact ID.
     *
     * @var int
     */
    public $contact;

    /**
     * Automation ID.
     *
     * @var int
     */
    public $automation;
}
