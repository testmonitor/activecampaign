<?php

namespace PerfectWorkout\ActiveCampaign\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param $code
     * @return void
     */
    public function __construct($code = 404)
    {
        parent::__construct('The resource you are looking for could not be found.', $code);
    }
}
