<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PartieEtudiantController extends AbstractController
{
    #[Route('/partie/etudiant', name: 'app_partie_etudiant')]
    public function index(ClasseRepository $rep): Response
    {

        $classes=$rep->findAll();
        return $this->render('partie_etudiant/index.html.twig', [
            'classes' => $classes,
        ]);
    }
}
