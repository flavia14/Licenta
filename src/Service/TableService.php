<?php

namespace App\Service;

use App\Dto\RequestDtoSensor;
use App\Enum\BaseEnum;
use App\Repository\FrontSensorRepository;
use App\Repository\SensorRepository;
use App\Transformer\SensorsTransformer;

class TableService
{
    private SensorRepository $sensorRepository;
    private SensorsTransformer $sensorsTransformer;

    public function __construct(SensorRepository $sensorRepository, SensorsTransformer $sensorsTransformer)
    {
        $this->sensorRepository = $sensorRepository;
        $this->sensorsTransformer = $sensorsTransformer;
    }

    public function getFrontSensors(int $limit, RequestDtoSensor $requestDto): array
    {
        $requestDto->setSort(BaseEnum::sensorFilter[$requestDto->getSort()]);
       $sensors[] = $this->sensorRepository->getSensors("front", $limit, $requestDto);
       return $this->sensorsTransformer->convertSensorsToDto($sensors[0]);
    }

    public function getBackSensors(int $limit, RequestDtoSensor $requestDto): array
    {
        $requestDto->setSort(BaseEnum::sensorFilter[$requestDto->getSort()]);
        $sensors[] = $this->sensorRepository->getSensors("back", $limit, $requestDto);
        return $this->sensorsTransformer->convertSensorsToDto($sensors[0]);
    }

    public function getNumberOfPagesFront( int $limit): int
    {
        $numberOfPages = intdiv(count($this->sensorRepository->getAllSensors("front")), $limit) + 1;

        return $numberOfPages;
    }

    public function getNumberOfPagesBack( int $limit): int
    {
        $numberOfPages = intdiv(count($this->sensorRepository->getAllSensors("back")), $limit) + 1;

        return $numberOfPages;
    }
}