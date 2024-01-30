<?php

namespace App\Security;

use App\Entity\User;
use DateTime;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * @param User $user
     * @return void
     */
    public function checkPreAuth(UserInterface $user)
    {
        if (null === $user->getBannedUntil()) {
            return;
        }

        $now = new DateTime();

        if ($now > $user->getBannedUntil() && !$user->isVerified()) {
            throw new AccessDeniedHttpException('The user is banned');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {

    }
}
