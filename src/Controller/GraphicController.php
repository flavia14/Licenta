<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\FrontSensor;
use App\Entity\Sensor;
use App\Manager\GraphicManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GraphicController extends BaseController
{
    private GraphicManager $graphicManager;

    public function __construct(GraphicManager $graphicManager)
    {
        $this->graphicManager = $graphicManager;
    }

    #[Route('/graphic/front/{name}', name: 'graphic-front')]
    public function graphicSensorFront(Sensor $sensor): \Symfony\Component\HttpFoundation\Response
    {
        $dataSensor = $this->graphicManager->getDataSensorsFront($sensor->getName());
        return $this->render('graphic/graphic.html.twig',
            ["sensors" => $dataSensor,
                "name" => $sensor->getName(),
                ],
        );

    }

    #[Route('/graphic/back/{name}', name: 'graphic-back')]
    public function graphicSensorBack(Sensor $sensor): \Symfony\Component\HttpFoundation\Response
    {
        $dataSensor = $this->graphicManager->getDataSensorsBack($sensor->getName());

        return $this->render('graphic/graphic.html.twig',
            ["sensors" => $dataSensor,
                "name" => $sensor->getName(),
            ],
        );

    }
}