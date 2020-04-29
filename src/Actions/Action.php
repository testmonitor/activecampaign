<?php

namespace TestMonitor\ActiveCampaign\Actions;

/**
 * Class Action
 *
 * Defines methods implemented in MakeHttpRequest and ActiveCampaign that used in traits.
 */
trait Action
{
    abstract function get($uri, $payload = []);
    abstract function put($uri, array $payload = []);
    abstract function post($uri, array $payload = []);
    abstract function delete($uri, array $payload = []);
    abstract function transformCollection($collection, $class, $key = '', $extraData = []);
}
