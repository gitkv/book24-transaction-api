<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserAccount", inversedBy="owner", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private UserAccount $account;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail() : ?string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    public function getAccount() : ?UserAccount
    {
        return $this->account;
    }

    public function setAccount(UserAccount $account) : self
    {
        $this->account = $account;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'id'    => $this->getId(),
            'name'  => $this->getName(),
            'email' => $this->getEmail(),
        ];
    }
}
