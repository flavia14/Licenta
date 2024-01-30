<?php

declare(strict_types=1);

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterRequestDto
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    public string $username;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    public string $email;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    public string $password;
}
