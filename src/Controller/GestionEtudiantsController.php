<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
final class GestionEtudiantsController extends AbstractController
{
    #[Route('/api/listeEtudiants', name: 'app_liste_etudiants')]
    public function getAllEtudiants(): JsonResponse
    {
        return $this->json('');
    }
    #[Route('/api/deleteEtudiant/{id}', name: 'app_delete_etudiant')]
    public function deleteEtudiant(): JsonResponse

    {
        return $this->json('');
    }
    #[Route('/api/AddEtudiant', name: 'app_add_etudiant')]
    public function addEtudiant(): JsonResponse

    {
        return $this->json('');
    }
    #[Route('/api/RecherecheEtudiant', name: 'app_rech_etudiant')]
    public function RechEtudiant(): JsonResponse

    {
        return $this->json('');
    }
}
