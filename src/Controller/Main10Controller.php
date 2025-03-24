<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Main10Controller extends AbstractController
{
    #[Route('/main10', name: 'app_main10')]
    public function index(): Response
    {
        return $this->render('main10/index.html.twig', [
            'controller_name' => 'Main10Controller',
        ]);
    }
}
