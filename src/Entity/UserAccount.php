<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserAccountRepository")
 * @ORM\Table(name="user_accounts")
 */
class UserAccount implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $sum;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="account", cascade={"persist", "remove"})
     */
    private User $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="debitAccount")
     */
    private PersistentCollection $debitTransactions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="creditAccount")
     */
    private PersistentCollection $creditTransactions;

    public function __construct()
    {
        $this->debitTransactions = new ArrayCollection();
        $this->creditTransactions = new ArrayCollection();
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getSum() : ?int
    {
        return $this->sum;
    }

    public function setSum(int $sum) : self
    {
        $this->sum = $sum;

        return $this;
    }

    public function getOwner() : ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner) : self
    {
        $this->owner = $owner;

        // set the owning side of the relation if necessary
        if ($owner->getAccount() !== $this) {
            $owner->setAccount($this);
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getDebitTransactions() : Collection
    {
        return $this->debitTransactions;
    }

    public function addDebitTransaction(Transaction $debitTransaction) : self
    {
        if (!$this->debitTransactions->contains($debitTransaction)) {
            $this->debitTransactions[] = $debitTransaction;
            $debitTransaction->setDebitAccount($this);
        }

        return $this;
    }

    public function removeDebitTransaction(Transaction $debitTransaction) : self
    {
        if ($this->debitTransactions->contains($debitTransaction)) {
            $this->debitTransactions->removeElement($debitTransaction);
            // set the owning side to null (unless already changed)
            if ($debitTransaction->getDebitAccount() === $this) {
                $debitTransaction->setDebitAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getCreditTransactions() : Collection
    {
        return $this->creditTransactions;
    }

    public function addCreditTransaction(Transaction $creditTransaction) : self
    {
        if (!$this->creditTransactions->contains($creditTransaction)) {
            $this->creditTransactions[] = $creditTransaction;
            $creditTransaction->setCreditAccount($this);
        }

        return $this;
    }

    public function removeCreditTransaction(Transaction $creditTransaction) : self
    {
        if ($this->creditTransactions->contains($creditTransaction)) {
            $this->creditTransactions->removeElement($creditTransaction);
            // set the owning side to null (unless already changed)
            if ($creditTransaction->getCreditAccount() === $this) {
                $creditTransaction->setCreditAccount(null);
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id'    => $this->getId(),
            'sum'   => $this->getSum(),
            'owner' => $this->getOwner(),
        ];
    }
}
