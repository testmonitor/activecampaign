<?php

namespace TestMonitor\ActiveCampaign\Resources;

/** @deprecated use Account instead */
class Organization extends Resource
{
    /**
     * The id of the organization.
     *
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;
}
