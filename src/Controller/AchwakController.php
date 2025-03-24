<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AchwakController extends AbstractController
{
    #[Route('/achwak', name: 'app_achwak')]
    public function index(): Response
    {
        return $this->render('achwak/index.html.twig', [
            'controller_name' => 'AchwakController',
        ]);
    }
}
