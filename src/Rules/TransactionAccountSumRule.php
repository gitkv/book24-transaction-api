<?php

namespace App\Rules;


use App\Entity\UserAccount;
use App\Services\BusinessValidation\BusinessRule;

/**
 * Проверяет достаточн ли средств для совершения транзакции
 * Class TransactionAccountSumRule
 * @package App\Rules
 */
final class TransactionAccountSumRule extends BusinessRule
{
    /**
     * @var UserAccount
     */
    protected UserAccount $account;

    /**
     * @var int
     */
    protected int $amount;

    /**
     * TransactionAccountSumRule constructor.
     * @param UserAccount $account
     * @param int $amount
     */
    public function __construct(UserAccount $account, int $amount)
    {
        $this->amount = $amount;
        $this->account = $account;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'Для совершения транзакции недостаточно средств';
    }

    /**
     * @inheritDoc
     */
    public function passes()
    {
        return $this->account->getSum() > $this->amount;
    }
}
