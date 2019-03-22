<?php

namespace ByTestGear\ActiveCampaign\Resources;

class Resource
{
    /**
     * The resource attributes.
     *
     * @var array
     */
    public $attributes;

    /**
     * The TestMonitor SDK instance.
     *
     * @var \ByTestGear\ActiveCampaign\ActiveCampaign
     */
    protected $activeCampaign;

    /**
     * Create a new resource instance.
     *
     * @param  array $attributes
     * @param  \ByTestGear\ActiveCampaign\ActiveCampaign $activeCampaign
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

            $this->{$key} = $value;
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
