<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RahmaController extends AbstractController
{
    #[Route('/rahma', name: 'app_rahma')]
    public function index(): Response
    {
        return $this->render('rahma/index.html.twig', [
            'controller_name' => 'RahmaController',
        ]);
    }
}
