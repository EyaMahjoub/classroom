<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Main2Controller extends AbstractController
{
    #[Route('/main2', name: 'app_main2')]
    public function index(): Response
    {
        return $this->render('main2/yes.html.twig', [
            'controller_name' => 'Main2Controller',
        ]);
    }
}

