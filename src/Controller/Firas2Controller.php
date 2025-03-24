<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Firas2Controller extends AbstractController{
    #[Route('/firas2', name: 'app_firas2')]
    public function index(): Response
    {
        return $this->render('firas2/index.html.twig', [
            'controller_name' => 'Firas2Controller',
        ]);
    }
}
