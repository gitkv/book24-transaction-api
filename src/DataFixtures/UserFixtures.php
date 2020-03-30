<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserAccount;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private array $userData = [
        [
            'name'       => 'user1',
            'email'      => 'user1@mail.demo',
            'accountSum' => 1000,
        ],
        [
            'name'       => 'user2',
            'email'      => 'user2@mail.demo',
            'accountSum' => 1000,
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->userData as $userDatum) {
            $user = new User();
            $userAccount = new UserAccount();
            $userAccount->setSum($userDatum['accountSum']);

            $user
                ->setName($userDatum['name'])
                ->setEmail($userDatum['email'])
                ->setAccount($userAccount);

            $manager->persist($user);
            $manager->flush();
        }
    }
}
