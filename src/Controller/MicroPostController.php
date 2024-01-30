<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Manager\MicroPostManager;
use App\Transformer\MicroPostTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MicroPostController extends BaseController
{
    private MicroPostManager $microPostManager;
    private MicroPostTransformer $microPostTransformer;

    public function __construct(
        MicroPostManager     $microPostManager,
        MicroPostTransformer $microPostTransformer
    )
    {
        $this->microPostManager = $microPostManager;
        $this->microPostTransformer = $microPostTransformer;
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/posts', name: 'posts')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getListOfPost(): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $posts = $this->microPostManager->getListOfPosts($currentUser);

        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route('/post/top-liked', name: 'app_top_liked')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function topLiked(): Response
    {
        $posts = $this->microPostManager->getTopLikedPost();

        return $this->render(
            'post/topLiked.html.twig',
            [
                'posts' => $posts,
            ]
        );
    }

    #[Route('/post/add/{idProfile}', name: 'post-add-save', methods: 'POST', priority: 2)]
    #[IsGranted('ROLE_WRITER')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addMicroPost(Request $request): Response
    {
        $requestArray = $this->getRequestParameters($request);
        $requestDto = $this->microPostTransformer->convertRequestToDto($requestArray);

        $this->microPostManager->createMicroPost($this->getUser(), $requestDto);
        $this->addFlash('success', 'New post have been added');

        return $this->redirectToRoute('posts');
    }

    #[Route('/post/add', name: 'post-add', methods: 'GET', priority: 2)]
    #[IsGranted('ROLE_WRITER')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function addMicroPostRender(): Response
    {
        return $this->render(
            'post/createPost.html.twig'
        );
    }

    #[Route('/post/update/{id}', name: 'post-update', methods: 'GET')]
    #[IsGranted(MicroPost::EDIT, 'microPost')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function updateMicroPostRender(MicroPost $microPost): Response
    {
        return $this->render(
            'post/updatePost.html.twig',
            [
                'id' => $microPost->getId()
            ]
        );
    }

    #[Route('/post/update/{id}', name: 'post-update-save', methods: 'POST')]
    #[IsGranted(MicroPost::EDIT, 'microPost')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function updateMicroPost(Request $request, MicroPost $microPost): Response
    {
        $requestArray = $this->getRequestParameters($request);
        $requestDto = $this->microPostTransformer->convertRequestToDto($requestArray);

        $this->microPostManager->updateMicroPost($microPost, $requestDto);
        $this->addFlash('success', 'New post have been added');

        return $this->redirectToRoute('posts');
    }
}
