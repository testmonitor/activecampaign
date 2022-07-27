<?php

namespace PerfectWorkout\ActiveCampaign\Exceptions;

use Exception;

class RateLimitException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param $message
     * @param $code
     */
    public function __construct($message, $code = 429)
    {
        parent::__construct($message, $code);
    }
}
