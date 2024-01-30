<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Dto\Request\RegisterRequestDto;
use App\Dto\UserDto;
use App\Entity\User;

class UserTransformer
{
    public function convertRegisterRequestToDto(array $request): RegisterRequestDto
    {
        $registerRequestDto = new RegisterRequestDto();

        $registerRequestDto->username = $request['_username'];
        $registerRequestDto->email = $request['_email'];
        $registerRequestDto->password = $request['_password'];

        return $registerRequestDto;
    }

    public function convertUserEntityToDto(User $user): UserDto
    {
        $userDto = new UserDto();

        $userDto->username = $user->getUsername();
        $userDto->password = $user->getPassword();
        $userDto->email = $user->getEmail();

        return $userDto;
    }
}
