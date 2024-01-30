<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Manager\LikeManager;
use App\Repository\MicroPostRepository;
use App\Service\LikeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    private LikeManager $likeManager;

    public function __construct(
        LikeManager $likeManager
    ) {
        $this->likeManager = $likeManager;
    }
    #[Route('/like/{id}', name: 'app_like')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function like(MicroPost $microPost, Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
       $this->likeManager->addLike($microPost, $currentUser);

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/unlike/{id}', name: 'app_unlike')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function unlike(MicroPost $microPost, Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $this->likeManager->removeLike($microPost, $currentUser);

        return $this->redirect($request->headers->get('referer'));
    }
}
