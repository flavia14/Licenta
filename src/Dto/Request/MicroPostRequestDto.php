<?php

declare(strict_types=1);

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

class MicroPostRequestDto
{
    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    public string $text;

    /**
     * @Assert\Type("string")
     * @Assert\NotBlank()
     */
    public string $title;
}
