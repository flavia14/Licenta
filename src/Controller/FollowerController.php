<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Manager\FollowerManager;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FollowerController extends AbstractController
{
    private FollowerManager $followerManager;

    public function __construct(
        FollowerManager $followerManager
    ) {
        $this->followerManager = $followerManager;
    }
    #[Route('/follow/{id}', name: 'app_follow')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function follow( User $userToFollow,  Request $request): Response
    {  /** @var User $currentUser */
        $currentUser = $this->getUser();
        $this->followerManager->follow($currentUser, $userToFollow);

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/unfollow/{id}', name: 'app_unfollow')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function unfollow( User $userToUnfollow, Request $request): Response
    {  /** @var User $currentUser */
        $currentUser = $this->getUser();
        $this->followerManager->unfollow($currentUser, $userToUnfollow);

        return $this->redirect($request->headers->get('referer'));
    }
}
