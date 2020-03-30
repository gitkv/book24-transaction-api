<?php

namespace App\Tests;

use App\Entity\Transaction;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\BusinessValidation\BusinessValidationService;
use App\Services\TransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TransactionServiceTest extends KernelTestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var TransactionService
     */
    protected $service;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var User
     */
    protected $fromUser;

    /**
     * @var User
     */
    protected $toUser;

    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->service = new TransactionService($this->entityManager, new BusinessValidationService());
        $this->userRepository = $this->entityManager->getRepository(User::class);
        $this->fromUser = $this->userRepository->findOneBy(['email' => 'user1@mail.demo']);
        $this->toUser = $this->userRepository->findOneBy(['email' => 'user2@mail.demo']);
    }

    protected function tearDown() : void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    /**
     * тест успешнго прохождения транзакции
     */
    public function testPassTransaction()
    {
        $transaction = $this->service->create($this->fromUser, $this->toUser, 1);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals(1, $transaction->getAmount());
        $this->assertEquals($this->fromUser->getAccount(), $transaction->getDebitAccount());
        $this->assertEquals($this->toUser->getAccount(), $transaction->getCreditAccount());
    }

    /**
     * провал прохождения транзакции по недостатку средств на счету
     * @expectedException App\Exceptions\BusinessRuleValidationException
     */
    public function testFailTransactionNoMoney()
    {
        $this->service->create($this->fromUser, $this->toUser, 10000000000);
    }


    /**
     * провал прохождения транзакции по недостатку средств на счету
     * @expectedException App\Exceptions\BusinessRuleValidationException
     */
    public function testFailTransactionNegativeAmount()
    {
        $this->service->create($this->fromUser, $this->toUser, -1);
    }
}
