<?php

namespace App\Rules;


use App\Services\BusinessValidation\BusinessRule;

/**
 * Запрещает применять отрицательные значения
 * Class TransactionAmountRule
 * @package App\Rules
 */
final class TransactionAmountRule extends BusinessRule
{
    /**
     * @var int
     */
    protected $amount;

    /**
     * TransactionAmountRule constructor.
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'Нельзя использовать отрицательное количество';
    }

    /**
     * @inheritDoc
     */
    public function passes()
    {
        return $this->amount > 0;
    }
}
