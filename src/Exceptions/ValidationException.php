<?php

namespace PerfectWorkout\ActiveCampaign\Exceptions;

use Exception;

class ValidationException extends Exception
{
    /**
     * The array of errors.
     *
     * @var array
     */
    public $errors;

    /**
     * Create a new exception instance.
     *
     * @param array $errors
     * @param $code
     */
    public function __construct(array $errors, $code = 422)
    {
        parent::__construct('The given data failed to pass validation.', $code);

        $this->errors = $errors;
    }

    /**
     * The array of errors.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors['errors'] ?? [];
    }
}
