<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Request\RegisterRequestDto;
use App\Entity\User;
use App\Exception\BadCredentialsException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserService
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function createUser(
        RegisterRequestDto $requestDto,
        UserPasswordHasherInterface $userPasswordHasher
    ): User {
        $user = new User();

        $password = $userPasswordHasher->hashPassword($user, $requestDto->password);

        $user->setPassword($password)
            ->setUsername($requestDto->username)
            ->setEmail($requestDto->email);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function getLastUsername(AuthenticationUtils $utils): array
    {
        $error = $utils->getLastAuthenticationError();
        if ($error){
            throw new BadCredentialsException($error->getMessage(), 400);
        }

        $lastUsername = $utils->getLastUsername();

        return ['lastUsername' => $lastUsername];
    }
}
