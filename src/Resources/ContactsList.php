<?php

namespace TestMonitor\ActiveCampaign\Resources;

class ContactsList extends Resource
{
    /**
     * The id of the list.
     *
     * @var string
     */
    public $id;

    /**
     * Name of the list.
     *
     * @var string
     */
    public $name;

    /**
     * URL-safe list name. Example: 'list-name-sample'.
     *
     * @var string
     */
    public $stringid;

    /**
     * The website URL this list is for.
     *
     * @var string
     */
    public $senderUrl;

    /**
     * A reminder for your contacts as to why they are on this list and you are messaging them.
     * For example: 'You signed up for my mailing list.'.
     *
     * @var string
     */
    public $senderReminder;

    /**
     * Boolean value indicating whether or not to send the last sent campaign to this list to a
     * new subscriber upon subscribing. 1 = yes, 0 = no.
     *
     * @var bool
     */
    public $sendLastBroadcast;

    /**
     * Comma-separated list of email addresses to send a copy of all mailings to upon send.
     *
     * @var string
     */
    public $carboncopy;

    /**
     * Comma-separated list of email addresses to notify when a new subscriber joins this list.
     *
     * @var string
     */
    public $subscriptionNotify;

    /**
     * Comma-separated list of email addresses to notify when a subscriber unsubscribes from this list.
     *
     * @var string
     */
    public $unsubscriptionNotify;

    /**
     * User Id of the list owner. A list owner is able to control campaign branding.
     * A property of list.userid also exists on this object; both properties map to the same list owner
     * field and are being maintained in the response object for backward compatibility. If you post values
     * for both list.user and list.userid, the value of list.user will be used.
     *
     * @var int
     */
    public $user;

    /**
     * Get all contacts related to the list.
     *
     * @return Contact[]
     */
    public function contacts()
    {
        return $this->activeCampaign->contactsByList($this->id);
    }
}
