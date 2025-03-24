<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EyaMahjController extends AbstractController
{
    #[Route('/eya/mahj', name: 'app_eya_mahj')]
    public function index(): Response
    {
        return $this->render('eya_mahj/index.html.twig', [
            'controller_name' => 'EyaMahjController',
        ]);
    }
}
