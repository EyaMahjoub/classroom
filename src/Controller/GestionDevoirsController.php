<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
final class GestionDevoirsController extends AbstractController
{
    #[Route('/api/addDevoirs', name: 'app_add_devoir')]
    public function addDevoir(): JsonResponse
    {
        return $this->json('');
    }
    #[Route('/api/deleteDevoir/{id}', name: 'app_delete_devoir')]
    public function deleteDevoir(): JsonResponse

    {
        return $this->json('');
    }
    #[Route('/api/postDevoir/{id}', name: 'app_post_devoir')]
    public function postDevoir(): JsonResponse

    {
        return $this->json('');
    }
}
