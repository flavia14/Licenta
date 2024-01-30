<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @param $request
     * @return array
     */
    public function getRequestParameters($request): array
    {
        $requestData = array_replace_recursive(
            $request->query->all(),
            $request->request->all(),
            $request->files->all(),
            $request->attributes->all()['_route_params']
        );
        unset($requestData['_format']);

        if ($decodedContent = json_decode($request->getContent(), true)) {
            $requestData = array_merge($decodedContent, $requestData);
        }

        return $requestData;
    }
}
