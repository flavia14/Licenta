<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class SendEmailService
{
    private EmailVerifier $emailVerifier;
    public function __construct(
        EmailVerifier $emailVerifier
    ) {
        $this->emailVerifier = $emailVerifier;
    }

    public function sendConfirmationEmail(User $user): void
    {
        if (empty($user)) {
            throw new EntityNotFoundException("Entity not found");
        }

        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('flavia.andron@gmail.com', 'Flavia Andron'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
    }
}
