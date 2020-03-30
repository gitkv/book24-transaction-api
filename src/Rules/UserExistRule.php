<?php

namespace App\Rules;


use App\Entity\User;
use App\Services\BusinessValidation\BusinessRule;

/**
 * Проверка на существование пользователя
 * Class UserExistRule
 * @package App\Rules
 */
final class UserExistRule extends BusinessRule
{
    protected $user;

    /**
     * @var string
     */
    protected string $email;

    /**
     * UserExistRule constructor.
     * @param $user
     * @param string $email
     */
    public function __construct($user, string $email)
    {
        $this->user = $user;
        $this->email = $email;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return "Не найден пользователь с email {$this->email}";
    }

    /**
     * @inheritDoc
     */
    public function passes()
    {
        return $this->user instanceof User;
    }
}
