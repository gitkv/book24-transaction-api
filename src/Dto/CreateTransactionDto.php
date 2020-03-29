<?php


namespace App\Dto;


use Symfony\Component\Validator\Constraints as Assert;

final class CreateTransactionDto
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $from_user;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $to_user;

    /**
     * @var integer
     * @Assert\Type("integer")
     * @Assert\Expression("this.getAmount() > 0")
     */
    private $amount;

    /**
     * @return string
     */
    public function getFromUser() : string
    {
        return $this->from_user;
    }

    /**
     * @param string $from_user
     * @return CreateTransactionDto
     */
    public function setFromUser(string $from_user) : CreateTransactionDto
    {
        $this->from_user = $from_user;

        return $this;
    }

    /**
     * @return string
     */
    public function getToUser() : string
    {
        return $this->to_user;
    }

    /**
     * @param string $to_user
     * @return CreateTransactionDto
     */
    public function setToUser(string $to_user) : CreateTransactionDto
    {
        $this->to_user = $to_user;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount() : int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return CreateTransactionDto
     */
    public function setAmount(int $amount) : CreateTransactionDto
    {
        $this->amount = $amount;

        return $this;
    }
}