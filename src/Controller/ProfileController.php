<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\ProfileImageType;
use App\Form\UserProfileFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProfileController extends AbstractController
{
    #[Route('/profile/profile-image', name: 'profile_image')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profileImage(
        Request $request,
        SluggerInterface $slugger,
        UserRepository $users
    ): Response {

        $form = $this->createForm(ProfileImageType::class);

        /** @var User $user */
        $user = $this->getUser();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profileImageFile = $form->get('profileImage')->getData();

            if ($profileImageFile) {
                $originalFileName = pathinfo(
                    $profileImageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFilename = $slugger->slug($originalFileName);
                $newFileName = $safeFilename . '-' . uniqid() . '.' . $profileImageFile->guessExtension();

                try {
                    $profileImageFile->move(
                        $this->getParameter('profiles_directory'),
                        $newFileName
                    );
                } catch (FileException $e) {
                }

                $profile = $user->getUserProfile() ?? new UserProfile();
                $profile->setImage($newFileName);
                $user->setUserProfile($profile);
                $users->save($user, true);
                $this->addFlash('success', 'Your profile image was updated.');

                return $this->redirectToRoute('profile_image');
            }
        }

        return $this->render(
            'profile/profileImage.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/profile', name: 'profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(
        Request        $request,
        UserRepository $users
    ): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $userProfile = $user->getUserProfile() ?? new UserProfile();

        $form = $this->createForm(
            UserProfileFormType::class,
            $userProfile
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userProfile = $form->getData();
            $user->setUserProfile($userProfile);
            $users->save($user, true);
            $this->addFlash(
                'success',
                'Your user profile settings were saved.'
            );

            return $this->redirectToRoute(
                'posts'
            );
        }

        return $this->render(
            'profile/profile.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}