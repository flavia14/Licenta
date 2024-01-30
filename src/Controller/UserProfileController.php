<?php

namespace App\Controller;

use App\Repository\UserProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    #[Route('/profile-list', name: 'profile-list')]
    public function getListOfProfile(UserProfileRepository $profileRepository): Response
    {
        return new Response("this is the profile list");
    }
}
