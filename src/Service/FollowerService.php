<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\CanNotFollowCurrentUserException;
use Doctrine\Persistence\ManagerRegistry;

class FollowerService
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @throws CanNotFollowCurrentUserException
     */
    public function follow(User $currentUser, User $userToFollow): void
    {
        if ($userToFollow->getId() === $currentUser->getId()) {
            throw new CanNotFollowCurrentUserException("You can not follow your account.");
        }

        $currentUser->addFollow($userToFollow);
        $this->managerRegistry->getManager()->flush();
    }

    /**
     * @throws CanNotFollowCurrentUserException
     */
    public function unfollow(User $currentUser, User $userToUnFollow): void
    {

        if ($userToUnFollow->getId() === $currentUser->getId()) {
            throw new CanNotFollowCurrentUserException("You can not unfollow your account.");
        }

        $currentUser->removeFollow($userToUnFollow);
        $this->managerRegistry->getManager()->flush();
    }
}
