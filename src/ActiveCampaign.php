<?php

namespace TestMonitor\ActiveCampaign;

use GuzzleHttp\Client as HttpClient;
use TestMonitor\ActiveCampaign\Actions\ManagesAutomations;
use TestMonitor\ActiveCampaign\Actions\ManagesContactAutomations;
use TestMonitor\ActiveCampaign\Actions\ManagesContacts;
use TestMonitor\ActiveCampaign\Actions\ManagesContactTags;
use TestMonitor\ActiveCampaign\Actions\ManagesCustomFields;
use TestMonitor\ActiveCampaign\Actions\ManagesEvents;
use TestMonitor\ActiveCampaign\Actions\ManagesLists;
use TestMonitor\ActiveCampaign\Actions\ManagesOrganizations;
use TestMonitor\ActiveCampaign\Actions\ManagesTags;

class ActiveCampaign
{
    use MakesHttpRequests,
        ManagesAutomations,
        ManagesContacts,
        ManagesTags,
        ManagesContactTags,
        ManagesContactAutomations,
        ManagesCustomFields,
        ManagesOrganizations,
        ManagesEvents,
        ManagesLists;

    /**
     * The ActiveCampaign base url.
     *
     * @var string
     */
    public $apiUrl;

    /**
     * The ActiveCampaign API token.
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
     * Create a new ActiveCampaign instance.
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
            'base_uri' => "{$this->apiUrl}/api/3/",
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Api-Token' => $this->apiKey,
            ],
        ]);
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param  array $collection
     * @param  string $class
     * @param  string $key
     * @param  array $extraData
     *
     * @return array
     */
    protected function transformCollection($collection, $class, $key = '', $extraData = [])
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this);
        }, $collection[$key] ?? $collection);
    }
}
