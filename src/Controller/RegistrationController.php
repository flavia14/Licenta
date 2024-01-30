<?php

declare(strict_types=1);

namespace App\Controller;

use App\Manager\UserManager;
use App\Security\EmailVerifier;
use App\Transformer\UserTransformer;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends BaseController
{
    private EmailVerifier $emailVerifier;
    private UserManager $userManager;
    private UserTransformer $userTransformer;

    public function __construct(
        EmailVerifier $emailVerifier,
        UserManager $userManager,
        UserTransformer $userTransformer
    ) {
        $this->emailVerifier = $emailVerifier;
        $this->userManager = $userManager;
        $this->userTransformer= $userTransformer;
    }

    #[Route('/register', name: 'app-register')]
    public function register(): Response
    {
        return $this->render(
            'registration/register.html.twig'
        );
    }

    #[Route('/register/save', name: 'app-register-save')]
    public function saveRegister(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response {

        try {
            $requestArray = $this->getRequestParameters($request);
            $requestDto = $this->userTransformer->convertRegisterRequestToDto($requestArray);

            $this->userManager->register($requestDto, $userPasswordHasher);

            return $this->redirectToRoute('posts');
        } catch (\PDOException $e) {
            return $this->render('error.html.twig', [
                'message' => 'An error occurred during registration. Please try again later.',
                'path' => "app-register"
            ]);
        } catch (\Exception $e) {
            return $this->render('error.html.twig', [
                'message' => 'An error occurred during registration.',
                'path' => "app-register"
            ]);
        }
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());

        return $this->redirectToRoute('app_register');
    }
}
