<?php

namespace App\Exceptions;

use RuntimeException;

class BusinessRuleValidationException extends RuntimeException
{
    protected array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
