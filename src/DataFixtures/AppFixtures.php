<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {

    }
    public function load(ObjectManager $manager): void
    {
       $user1 = new User();
       $user1->setUsername('flavia')
           ->setPassword(
               $this->userPasswordHasher->hashPassword(
                   $user1,
                   'flavia'
               )
           );
       $manager->persist($user1);


        $user2 = new User();
        $user2->setUsername('flaviaAndron')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user2,
                    'flavia'
                )
            );
        $manager->persist($user2);

        $manager->flush();
    }
}
