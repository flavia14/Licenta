<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;

class MicroPostDto
{
    public string $text;
    public string $title;
    public UserDto $author;
}
