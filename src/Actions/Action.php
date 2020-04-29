<?php

namespace TestMonitor\ActiveCampaign\Actions;

/**
 * Class Action.
 *
 * Defines methods implemented in MakeHttpRequest and ActiveCampaign that used in traits.
 */
trait Action
{
    abstract protected function get($uri, $payload = []);

    abstract protected function put($uri, array $payload = []);

    abstract protected function post($uri, array $payload = []);

    abstract protected function delete($uri, array $payload = []);

    abstract protected function transformCollection($collection, $class, $key = '', $extraData = []);
}
