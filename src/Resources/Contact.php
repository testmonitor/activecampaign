<?php

namespace ByTestGear\ActiveCampaign\Resources;

class Contact extends Resource
{
    /**
     * The id of the contact.
     *
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $email;

    /**
     * @var int
     */
    public $orgid;
}
