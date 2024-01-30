<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Request\MicroPostRequestDto;
use App\Entity\MicroPost;
use App\Entity\User;
use App\Enum\BaseEnum;
use App\Manager\MicroPostManager;
use App\Repository\MicroPostRepository;

class MicroPostService
{
    private MicroPostRepository $microPostRepository;

    public function __construct(MicroPostRepository $microPostRepository)
    {
        $this->microPostRepository = $microPostRepository;
    }

    public function getListOfPosts(User $user): array
    {
        return $this->microPostRepository->findAllByAuthors($user->getFollows());
    }

    public function getTopLikedPost(): array
    {
        return $this->microPostRepository->findAllWithMinLikes(BaseEnum::MIN_LIKE);
    }

    public function createMicroPost(User $user, MicroPostRequestDto $requestDto): void
    {
        $post = new MicroPost();

        $post->setAuthor($user)
            ->setText($requestDto->text)
            ->setTitle($requestDto->title)
            ->setCreatAt(new \DateTime());

        $this->microPostRepository->save($post, true);
    }

    public function updateMicroPost(MicroPost $microPost, MicroPostRequestDto $requestDto): void
    {
        $microPost->setText($requestDto->text)
            ->setTitle($requestDto->title);

        $this->microPostRepository->save($microPost, true);
    }

    public function getAllPostsByAuthor(int $userId): array
    {
        return $this->microPostRepository->findAllByAuthor($userId);
    }
}
