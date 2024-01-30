<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(UserRepository $user): Response
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user->findAll()
        ]);
    }

    #[Route('/user/{user}', name: 'showOne')]
    public function showOne(User $user): Response
    {
        return $this->render('user/showOne.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/user/add', name: 'user_add', priority: 2)]
    public function add(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, new User());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userRepository->save($user, true);
            $this->addFlash('success', 'New user have been added');

            return $this->redirectToRoute('user');
        }
        return $this->renderForm(
            'user/createUser.html.twig',
            [
                'form' => $form
            ]
        );
    }

    #[Route('/user/update/{id}', name: 'user-update')]
    public function update(User $user, Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userRepository->save($user, true);
            $this->addFlash('success', 'New user have been update');

            return $this->redirectToRoute('user');
        }
        return $this->renderForm(
            'user/createUser.html.twig',
            [
                'form' => $form
            ]
        );
    }
}
