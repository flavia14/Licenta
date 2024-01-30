<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Dto\MicroPostDto;
use App\Dto\Request\MicroPostRequestDto;
use App\Entity\MicroPost;
use App\Entity\User;

class MicroPostTransformer
{
    private UserTransformer $userTransformer;

    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }
    public function convertMicroPostsToDto(array $microPosts): array
    {
        $microPostsDto = [];
        foreach ($microPosts as $microPost) {
            $microPostsDto[] = $this->convertMicroPostToDto($microPost);
        }

        return $microPostsDto;
    }

    public function convertRequestToDto(array $request): MicroPostRequestDto
    {
        $microPostRequestDto = new MicroPostRequestDto();

        $microPostRequestDto->text = $request['text'];
        $microPostRequestDto->title = $request['title'];

        return $microPostRequestDto;
    }

    protected function convertMicroPostToDto(MicroPost $microPost): MicroPostDto
    {
        $microPostDto = new MicroPostDto();
        $microPostDto->text = $microPost->getText();
        $microPostDto->title = $microPost->getTitle();
        $microPostDto->author =  $this->userTransformer->convertUserEntityToDto($microPost->getAuthor());

        return $microPostDto;
    }
}
