<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FirasController extends AbstractController{
    #[Route('/firas', name: 'app_firas')]
    public function index(): Response
    {
        return $this->render('firas/index.html.twig', [
            'controller_name' => 'FirasController',
        ]);
    }
}
