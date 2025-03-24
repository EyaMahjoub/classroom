<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Firas3Controller extends AbstractController{
    #[Route('/firas3', name: 'app_firas3')]
    public function index(): Response
    {
        return $this->render('firas3/index.html.twig', [
            'controller_name' => 'Firas3Controller',
        ]);
    }
}
