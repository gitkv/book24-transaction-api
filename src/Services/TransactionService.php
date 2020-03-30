<?php


namespace App\Services;


use App\Entity\Transaction;
use App\Entity\User;
use App\Rules\TransactionAccountSumRule;
use App\Rules\TransactionAmountRule;
use App\Services\BusinessValidation\BusinessValidationService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class TransactionService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var BusinessValidationService
     */
    private BusinessValidationService $businessValidationService;

    /**
     * TransactionService constructor.
     * @param EntityManagerInterface $entityManager
     * @param BusinessValidationService $businessValidationService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        BusinessValidationService $businessValidationService
    ) {
        $this->entityManager = $entityManager;
        $this->businessValidationService = $businessValidationService;
    }

    public function create(User $fromUser, User $toUser, int $amount) : Transaction
    {
        return $this->entityManager->transactional(
            function ($em) use ($fromUser, $toUser, $amount) {
                $accountFrom = $fromUser->getAccount();
                $accountTo = $toUser->getAccount();

                $this->businessValidationService->validate(
                    [
                        new TransactionAmountRule($amount),
                        new TransactionAccountSumRule($accountFrom, $amount),
                    ]
                );

                $accountFrom->setSum($accountFrom->getSum() - $amount);
                $accountTo->setSum($accountTo->getSum() + $amount);

                $transaction = (new Transaction())
                    ->setAmount($amount)
                    ->setCreditAccount($accountTo)
                    ->setDate(new DateTimeImmutable("now"));

                $accountFrom->addDebitTransaction($transaction);

                $em->persist($transaction);
                $em->flush();

                return $transaction;
            }
        );
    }
}
