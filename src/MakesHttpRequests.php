<?php

namespace TestMonitor\ActiveCampaign;

use Psr\Http\Message\ResponseInterface;
use TestMonitor\ActiveCampaign\Exceptions\FailedActionException;
use TestMonitor\ActiveCampaign\Exceptions\NotFoundException;
use TestMonitor\ActiveCampaign\Exceptions\ValidationException;

/**
 * Class MakesHttpRequests.
 *
 * @property \GuzzleHttp\Client $guzzle
 */
trait MakesHttpRequests
{
    /**
     * Make a GET request to ActiveCampaign and return the response.
     *
     * @param  string $uri
     * @param array $payload
     *
     * @throws \TestMonitor\ActiveCampaign\Exceptions\FailedActionException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\NotFoundException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\ValidationException
     *
     * @return mixed
     */
    private function get($uri, $payload = [])
    {
        return $this->request('GET', $uri, $payload);
    }

    /**
     * Make a POST request to ActiveCampaign and return the response.
     *
     * @param  string $uri
     * @param  array $payload
     *
     * @throws \TestMonitor\ActiveCampaign\Exceptions\FailedActionException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\NotFoundException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\ValidationException
     *
     * @return mixed
     */
    private function post($uri, array $payload = [])
    {
        return $this->request('POST', $uri, $payload);
    }

    /**
     * Make a PUT request to ActiveCampaign and return the response.
     *
     * @param  string $uri
     * @param  array $payload
     *
     * @throws \TestMonitor\ActiveCampaign\Exceptions\FailedActionException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\NotFoundException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\ValidationException
     *
     * @return mixed
     */
    private function put($uri, array $payload = [])
    {
        return $this->request('PUT', $uri, $payload);
    }

    /**
     * Make a DELETE request to ActiveCampaign and return the response.
     *
     * @param  string $uri
     * @param  array $payload
     *
     * @throws \TestMonitor\ActiveCampaign\Exceptions\FailedActionException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\NotFoundException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\ValidationException
     *
     * @return mixed
     */
    private function delete($uri, array $payload = [])
    {
        return $this->request('DELETE', $uri, $payload);
    }

    /**
     * Make request to ActiveCampaign and return the response.
     *
     * @param  string $verb
     * @param  string $uri
     * @param  array $payload
     *
     * @throws \TestMonitor\ActiveCampaign\Exceptions\FailedActionException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\NotFoundException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\ValidationException
     *
     * @return mixed
     */
    private function request($verb, $uri, array $payload = [])
    {
        $response = $this->guzzle->request(
            $verb,
            $uri,
            $payload
        );

        if (! in_array($response->getStatusCode(), [200, 201])) {
            return $this->handleRequestError($response);
        }

        $responseBody = (string) $response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    /**
     * @param  \Psr\Http\Message\ResponseInterface $response
     *
     * @throws \TestMonitor\ActiveCampaign\Exceptions\ValidationException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\NotFoundException
     * @throws \TestMonitor\ActiveCampaign\Exceptions\FailedActionException
     * @throws \Exception
     *
     * @return void
     */
    private function handleRequestError(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 422) {
            throw new ValidationException(json_decode((string) $response->getBody(), true));
        }

        if ($response->getStatusCode() == 404) {
            throw new NotFoundException();
        }

        if ($response->getStatusCode() == 400) {
            throw new FailedActionException((string) $response->getBody());
        }

        throw new \Exception((string) $response->getBody());
    }
}
