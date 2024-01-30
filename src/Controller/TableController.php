<?php

namespace App\Controller;

use App\Dto\RequestDtoSensor;
use App\Manager\TableManager;
use  Symfony\Component\HttpFoundation\Response;
use JetBrains\PhpStorm\NoReturn;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends BaseController
{

    private TableManager $tableManager;

    public function __construct(TableManager $tableManager)
    {
        $this->tableManager = $tableManager;
    }

    #[NoReturn] #[Route('/frontSensors', name: 'front-sensors')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getFrontSensorsTable(Request $request): Response
    {
        $requestDto = new RequestDtoSensor(
            $request->query->get('sort', 'name'),
            $request->query->get('order', 'asc'),
            (int)$request->query->get('page', 1),
        );

        $limit = 12;
        $numberOfPages = $this->tableManager->getNumberOfPagesFront( $limit);
        $sensors = $this->tableManager->getFrontSensors($limit, $requestDto);

        return $this->render('tabel/tabel.html.twig',
            ["title" => 'Front Sensors',
                'path' => 'graphic-front',
                "sensors" => $sensors,
                "numPages" =>$numberOfPages,
                'currentPage' => $request->query->get('page', 1),
                'sort' => $request->query->get('sort', 'name'),
                'order' => $request->query->get('order', 'desc')
                ],
        );
    }

    #[NoReturn] #[Route('/backSensors', name: 'back-sensors')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function getBackSensorsTable(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $user = $this->getUser();
        $requestDto = new RequestDtoSensor(
            $request->query->get('sort', 'name'),
            $request->query->get('order', 'asc'),
            (int)$request->query->get('page', 1),
        );

        $limit = 12;
        $numberOfPages = $this->tableManager->getNumberOfPagesBack( $limit);
        $sensors = $this->tableManager->getBackSensors($limit, $requestDto);


        return $this->render('tabel/tabel.html.twig',
            [
                "title" => 'Back Sensors',
                'path' => 'graphic-back',
                "sensors" => $sensors,
                "numPages" =>$numberOfPages,
                'currentPage' => $request->query->get('page', 1),
                'sort' => $request->query->get('sort', 'name'),
                'order' => $request->query->get('order', 'desc')
            ],
        );
    }
}
