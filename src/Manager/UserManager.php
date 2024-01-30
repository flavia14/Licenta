<?php

declare(strict_types=1);

namespace App\Manager;

use App\Dto\Request\RegisterRequestDto;
use App\Service\SendEmailService;
use App\Service\UserService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager extends AbstractManager
{
    protected UserService $userService;
    protected SendEmailService $sendEmailService;
    public function __construct(
        UserService $userService,
        SendEmailService $sendEmailService
    ){
        $this->userService = $userService;
        $this->sendEmailService = $sendEmailService;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function register(RegisterRequestDto $requestDto, UserPasswordHasherInterface $userPasswordHasher): void
    {
        $user = $this->userService->createUser($requestDto, $userPasswordHasher);

        $this->sendEmailService->sendConfirmationEmail($user);
    }
}
