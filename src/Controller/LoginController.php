<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\UserManager;
use Exception;
use PDOException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    public const APP_LOGIN = 'app_login';
    public const APP_LOGOUT = 'app_logout';
    public UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    #[Route('/login', name: self::APP_LOGIN)]
    public function login(AuthenticationUtils $utils): Response
    {
        try {
            return $this->render('login/index.html.twig', $this->userManager->getLastUsername($utils));
        } catch (PDOException $e) {
            return $this->render('error.html.twig', ['message' => 'An error occurred during login. Please try again later.',  'path' => "app_login"]);
        } catch (Exception $e) {
            return $this->render('error.html.twig', ['message' => 'An error occurred during login.', 'path' => "app_login"]);
        }
    }

    #[Route('/logout', name: self::APP_LOGOUT)]
    public function logout(): void
    {
    }
}
