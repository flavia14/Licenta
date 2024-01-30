<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\User;
use App\Service\MicroPostService;

class MicroPostManager extends AbstractManager
{
    protected MicroPostService $microPostService;

    public function __construct(MicroPostService $microPostService)
    {
        $this->microPostService = $microPostService;
    }
}
