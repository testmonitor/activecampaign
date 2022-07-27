<?php

namespace PerfectWorkout\ActiveCampaign;

use Psr\Http\Message\ResponseInterface;
use PerfectWorkout\ActiveCampaign\Exceptions\NotFoundException;
use PerfectWorkout\ActiveCampaign\Exceptions\ValidationException;
use PerfectWorkout\ActiveCampaign\Exceptions\FailedActionException;
use PerfectWorkout\ActiveCampaign\Exceptions\RateLimitException;

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
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\FailedActionException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\NotFoundException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\ValidationException
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
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\FailedActionException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\NotFoundException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\ValidationException
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
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\FailedActionException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\NotFoundException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\ValidationException
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
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\FailedActionException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\NotFoundException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\ValidationException
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
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\FailedActionException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\NotFoundException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\ValidationException
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
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\ValidationException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\NotFoundException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\FailedActionException
     * @throws \PerfectWorkout\ActiveCampaign\Exceptions\RateLimitException
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

        if ($response->getStatusCode() == 429) {
            throw new RateLimitException((string) $response->getBody());
        }

        //adding the status code so its returned in non custom exceptions
        throw new \Exception((string) $response->getBody(), $response->getStatusCode());
    }
}
