<?php

namespace ByTestGear\ActiveCampaign;

use GuzzleHttp\Client as HttpClient;
use ByTestGear\ActiveCampaign\Actions\Tags;
use ByTestGear\ActiveCampaign\Actions\Contacts;
use ByTestGear\ActiveCampaign\Actions\Automations;
use ByTestGear\ActiveCampaign\Actions\CustomFields;
use ByTestGear\ActiveCampaign\Actions\Organizations;
use ByTestGear\ActiveCampaign\Actions\ContactAutomation;

class ActiveCampaign
{
    use MakesHttpRequests,
        Automations,
        ContactAutomation,
        Contacts,
        CustomFields,
        Organizations,
        Tags;

    /**
     * The TestMonitor API url.
     *
     * @var string
     */
    public $apiUrl;

    /**
     * The TestMonitor API Key.
     *
     * @var string
     */
    public $apiKey;

    /**
     * The Guzzle HTTP Client instance.
     *
     * @var \GuzzleHttp\Client
     */
    public $guzzle;

    /**
     * Number of seconds a request is retried.
     *
     * @var int
     */
    public $timeout = 30;

    /**
     * Create a new TestMonitor instance.
     *
     * @param string $apiUrl
     * @param string $apiKey
     * @param \GuzzleHttp\Client $guzzle
     */
    public function __construct($apiUrl, $apiKey, HttpClient $guzzle = null)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;

        $this->guzzle = $guzzle ?: new HttpClient([
            'base_uri' => $this->apiUrl,
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param  array $collection
     * @param  string $class
     * @param  array $extraData
     *
     * @return array
     */
    protected function transformCollection($collection, $class, $key, $extraData = [])
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this);
        }, $collection[$key]);
    }

    /**
     * Set a new timeout.
     *
     * @param  int $timeout
     *
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Get the timeout.
     *
     * @return  int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
}
