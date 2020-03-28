<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="bigint")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserAccount", inversedBy="debitTransactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $debitAccount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserAccount", inversedBy="creditTransactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creditAccount;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getDate() : ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date) : self
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

    public function getDebitAccount(): ?UserAccount
    {
        return $this->debitAccount;
    }

    public function setDebitAccount(?UserAccount $debitAccount): self
    {
        $this->debitAccount = $debitAccount;

        return $this;
    }

    public function getCreditAccount(): ?UserAccount
    {
        return $this->creditAccount;
    }

    public function setCreditAccount(?UserAccount $creditAccount): self
    {
        $this->creditAccount = $creditAccount;

        return $this;
    }
}
