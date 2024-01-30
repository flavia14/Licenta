<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): Response
    {
        return new Response("Hello");
    }
}
