<?php

namespace TestMonitor\ActiveCampaign\Resources;

class ContactTag extends Resource
{
    /**
     * The id of the contact tag.
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
     * Tag ID.
     *
     * @var int
     */
    public $tag;
}
