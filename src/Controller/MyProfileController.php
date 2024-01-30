<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\CanNotFollowCurrentUserException;
use App\Manager\MicroPostManager;
use Exception;
use PDOException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\ErrorMappingException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyProfileController extends AbstractController
{
    private MicroPostManager $microPostManager;

    public function __construct(MicroPostManager $microPostManager)
    {
        $this->microPostManager = $microPostManager;
    }

    #[Route('/myProfile/{id}', name: 'app_my_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function showMyProfile(User $user): Response
    {
        try {
            $posts = $this->microPostManager->getAllPostsByAuthor($user->getId());
        } catch (Exception $e) {
            return $this->render('error.html.twig', ['message' => 'An error occurred during login. Please try again later.', 'path' => "app_login"]);
        } catch (ErrorMappingException $e) {
            return $this->render('error.html.twig', ['message' => 'An error occurred during login.', 'path' => "app_login"]);
        }
        return $this->render('my_profile/show.html.twig', ['user' => $user, 'posts' => $posts]);
    }
}
