<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 * @ORM\Table(name="transactions")
 */
class Transaction implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="bigint")
     */
    private int $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserAccount", inversedBy="debitTransactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private UserAccount $debitAccount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserAccount", inversedBy="creditTransactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private UserAccount $creditAccount;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getDate() : ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date) : self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount() : ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount) : self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDebitAccount() : ?UserAccount
    {
        return $this->debitAccount;
    }

    public function setDebitAccount(?UserAccount $debitAccount) : self
    {
        $this->debitAccount = $debitAccount;

        return $this;
    }

    public function getCreditAccount() : ?UserAccount
    {
        return $this->creditAccount;
    }

    public function setCreditAccount(?UserAccount $creditAccount) : self
    {
        $this->creditAccount = $creditAccount;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id'             => $this->id,
            'debit_account'  => $this->debitAccount,
            'credit_account' => $this->creditAccount,
            'date'           => $this->date->format(DateTime::ATOM),
            'amount'         => $this->amount,
        ];
    }
}
