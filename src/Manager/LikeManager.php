<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\LikeService;

class LikeManager extends AbstractManager
{
    protected LikeService $likeService;

    public function __construct(
        LikeService $likeService
    ) {
        $this->likeService = $likeService;
    }
}
