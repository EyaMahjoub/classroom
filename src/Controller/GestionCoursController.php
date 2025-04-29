<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
final class GestionCoursController extends AbstractController
{
    #[Route('/api/listeCours', name: 'app_liste_cours')]
    public function getAllCours(): JsonResponse
    {
        return $this->json('');
    }
    #[Route('/api/deleteCours/{id}', name: 'app_delete_cours')]
    public function deleteCours(): JsonResponse
    {
        return $this->json('');
    }
    #[Route('/api/PosteCours', name: 'app_post_cours')]
    public function posteCours(): JsonResponse
    {
        return $this->json('');
    }

}
