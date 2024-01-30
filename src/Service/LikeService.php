<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Repository\MicroPostRepository;

class LikeService
{
    private MicroPostRepository $microPostRepository;

    public function __construct(
        MicroPostRepository $microPostRepository
    ) {
        $this->microPostRepository = $microPostRepository;
    }
    public function addLike(MicroPost $microPost, User $currentUser): void
    {
        $microPost->addLikedBy($currentUser);
        $this->microPostRepository->save($microPost, true);
    }

    public function removeLike(MicroPost $microPost, User $currentUser): void
    {
        $microPost->removeLikedBy($currentUser);
        $this->microPostRepository->save($microPost, true);
    }
}
