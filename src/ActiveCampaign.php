<?php

namespace ByTestGear\ActiveCampaign;

use GuzzleHttp\Client as HttpClient;
use ByTestGear\ActiveCampaign\Actions\ManagesTags;
use ByTestGear\ActiveCampaign\Actions\ManagesContacts;
use ByTestGear\ActiveCampaign\Actions\ManagesAutomations;
use ByTestGear\ActiveCampaign\Actions\ManagesContactTags;
use ByTestGear\ActiveCampaign\Actions\ManagesCustomFields;
use ByTestGear\ActiveCampaign\Actions\ManagesOrganizations;
use ByTestGear\ActiveCampaign\Actions\ManagesContactAutomations;

class ActiveCampaign
{
    use MakesHttpRequests,
        ManagesAutomations,
        ManagesContacts,
        ManagesTags,
        ManagesContactTags,
        ManagesContactAutomations,
        ManagesCustomFields,
        ManagesOrganizations;

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
