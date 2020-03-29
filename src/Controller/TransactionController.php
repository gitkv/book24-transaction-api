<?php

namespace App\Controller;

use App\Dto\CreateTransactionDto;
use App\Entity\User;
use App\Services\TransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    /**
     * @var TransactionService
     */
    private $service;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * TransactionController constructor.
     * @param TransactionService $service
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(TransactionService $service, EntityManagerInterface $entityManager)
    {
        $this->service = $service;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/transaction", name="createTransaction", methods={"POST"})
     * @param CreateTransactionDto $createTransactionDto
     * @return JsonResponse
     */
    public function create(CreateTransactionDto $createTransactionDto) : JsonResponse
    {
        $userRepository = $this->entityManager->getRepository(User::class);

        $fromUser = $userRepository->findOneBy(['email' => $createTransactionDto->getFromUser()]);
        $toUser = $userRepository->findOneBy(['email' => $createTransactionDto->getToUser()]);

        $transaction = $this->service->create($fromUser, $toUser, $createTransactionDto->getAmount());

        return $this->json($transaction);
    }
}
