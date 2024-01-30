<?php

namespace App\Service;

use App\Repository\FrontSensorRepository;
use App\Repository\SensorRepository;
use App\Transformer\SensorsTransformer;
use Symfony\Component\BrowserKit\Request;

class GraphicService
{
    private sensorRepository $sensorRepository;
    private SensorsTransformer $sensorsTransformer;

    public function __construct(SensorRepository $sensorRepository, SensorsTransformer $sensorsTransformer)
    {
        $this->sensorRepository = $sensorRepository;
        $this->sensorsTransformer = $sensorsTransformer;
    }

    public function getDataSensorsFront(string $name)
    {
        $sensors = $this->sensorRepository->getDataSensors('front', $name);
         return $this->sensorsTransformer->convertSensorsToDto($sensors);
    }
    public function getDataSensorsBack(string $name)
    {
        $sensors = $this->sensorRepository->getDataSensors('back', $name);
        return $this->sensorsTransformer->convertSensorsToDto($sensors);
    }
}
