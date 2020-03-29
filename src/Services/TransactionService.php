<?php


namespace App\Services;


use App\Entity\Transaction;
use App\Entity\User;
use App\Exceptions\TransactionException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class TransactionService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * TransactionService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(User $fromUser, User $toUser, int $amount) : Transaction
    {
        $transaction = $this->entityManager->transactional(function ($em) use ($fromUser, $toUser, $amount) {

            $accountFrom = $fromUser->getAccount();
            $accountTo = $toUser->getAccount();

            if ($amount < 0) {
                throw new TransactionException('Нельзя использовать отрицательное количество', 400);
            }

            if ($accountFrom->getSum() < $amount) {
                throw new TransactionException('Для совершения транзакции недостаточно средств', 400);
            }

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
        });

        return $transaction;
    }
}
