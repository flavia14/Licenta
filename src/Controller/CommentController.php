<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MicroPost;
use App\Manager\CommentManager;
use App\Transformer\CommentTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends BaseController
{
    private CommentManager $commentManager;
    private CommentTransformer $commentTransformer;

    public function __construct(
        CommentManager        $commentManager,
        CommentTransformer    $commentTransformer
    )
    {
        $this->commentManager = $commentManager;
        $this->commentTransformer = $commentTransformer;
    }

    #[Route('/comments/{id}', name: 'comments')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getListOfComments(MicroPost $microPost): Response
    {
        $comments = $this->commentManager->getListOfComments($microPost->getId());

        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('comment/add/{id}', name: 'add-comment', methods: 'GET')]
    #[ParamConverter("microPost", MicroPost::class)]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addComment(MicroPost $microPost): Response
    {
        return $this->render(
            'comment/comment.html.twig',
            [
                'id' => $microPost->getId()
            ]
        );
    }

    #[Route('comment/add/{id}', name: 'add-comment-save', methods: 'POST')]
    #[ParamConverter("microPost", MicroPost::class)]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function saveComment(MicroPost $microPost, Request $request): Response
    {
        $requestArray = $this->getRequestParameters($request);
        $requestDto = $this->commentTransformer->convertRequestToDto($requestArray);
        $this->commentManager->addComment($microPost, $requestDto);
        $this->addFlash('success', 'Your comment have been added');

        return $this->redirectToRoute('posts');
    }
}
