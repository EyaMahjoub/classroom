<?php

namespace App\Controller;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


final class GestionCoursController extends AbstractController
{
    #[Route('/api/listeCours/{id}', name: 'app_liste_cours')]
    public function getAllCours(CoursRepository $rep,$id,SerializerInterface $serializer): JsonResponse
    {
        $cours=$rep->findCoursByEnseignant($id);
        $data = $serializer->serialize($cours, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId(); // retourne juste l'id au lieu de boucler
            },
        ]);
        return new JsonResponse($data, 200, [], true);
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
