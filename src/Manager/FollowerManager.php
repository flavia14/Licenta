<?php

declare(strict_types=1);

namespace App\Manager;

use App\Service\FollowerService;

class FollowerManager extends AbstractManager
{
    protected FollowerService $followerService;

    public function __construct(FollowerService $followerService)
    {
        $this->followerService = $followerService;
    }
}
