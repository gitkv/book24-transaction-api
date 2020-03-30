<?php

namespace App\Services\BusinessValidation;


abstract class BusinessRule
{

    public bool $when = true;

    /**
     * Determine if the validation rule passes.
     *
     * @return bool
     */
    abstract public function passes();

    /**
     * Get the validation error message.
     *
     * @return string
     */
    abstract public function message();

    /**
     * @param $condition
     * @return mixed
     */
    public function when($condition)
    {
        $this->when = $condition;

        return $this;
    }
}
