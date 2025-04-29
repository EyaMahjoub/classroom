<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GestionClassesController extends AbstractController
{
    #[Route('/api/listeClasses', name: 'app_liste_classes')]
    public function getAllClasses(): JsonResponse
    {
        return $this->json('');
    }
    #[Route('/api/deleteClasse/{id}', name: 'app_remove_classe')]
    public function deleteClasse(): JsonResponse
    {
        return $this->json('');
    }
    #[Route('/api/addClasse', name: 'app_ajouter_classe')]
    public function addClasse(): JsonResponse
    {
        return $this->json('');
    }
}
