<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/menu', name: "menu")]
    public function menu()
    {
        $user = $this->getUser();
        return $this->render('menu/menu.html.twig',
            [ 'user' => $user]
        );
    }
}