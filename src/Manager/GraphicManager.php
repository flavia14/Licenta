<?php

namespace App\Manager;

use App\Service\GraphicService;

class GraphicManager extends AbstractManager
{
    protected GraphicService $graphicService;

    public function __construct(GraphicService $graphicService)
    {
        $this->graphicService = $graphicService;
    }
}
