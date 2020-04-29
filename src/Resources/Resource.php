<?php

namespace TestMonitor\ActiveCampaign\Resources;

class Resource
{
    /**
     * The resource attributes.
     *
     * @var array
     */
    public $attributes;

    /**
     * The ActiveCampaign SDK instance.
     *
     * @var \TestMonitor\ActiveCampaign\ActiveCampaign
     */
    protected $activeCampaign;

    /**
     * Create a new resource instance.
     *
     * @param  array $attributes
     * @param  \TestMonitor\ActiveCampaign\ActiveCampaign $activeCampaign
     * @return void
     */
    public function __construct(array $attributes, $activeCampaign = null)
    {
        $this->attributes = $attributes;
        $this->activeCampaign = $activeCampaign;

        $this->fill();
    }

    /**
     * Fill the resource with the array of attributes.
     *
     * @return void
     */
    private function fill()
    {
        foreach ($this->attributes as $key => $value) {
            $key = $this->camelCase($key);

            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Convert the key name to camel case.
     *
     * @param $key
     *
     * @return mixed
     */
    private function camelCase($key)
    {
        $parts = explode('_', $key);

        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $parts[$i] = ucfirst($part);
            }
        }

        return str_replace(' ', '', implode(' ', $parts));
    }
}
