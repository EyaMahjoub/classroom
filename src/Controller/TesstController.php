<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TesstController extends AbstractController
{
    #[Route('/tesst', name: 'app_tesst')]
    public function index(): Response
    {
        return $this->render('tesst/index.html.twig', ['salut'=>"saluttttt"         ]);
    }
}
