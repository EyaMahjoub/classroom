<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Main3Controller extends AbstractController{
    #[Route('/main3', name: 'app_main3')]
    public function index(): Response
    {
        return $this->render('main3/index.html.twig', [
            'controller_name' => 'Main3Controller',
        ]);
    }
}
