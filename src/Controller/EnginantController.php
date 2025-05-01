<?php

namespace App\Controller;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Classe;
use App\Repository\ClasseRepository;
use App\Repository\EtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
final class EnginantController extends AbstractController
{
    #[Route('/api/enginant/{id}', name: 'app_enginant')]
    public function index($id,ClasseRepository $rep, SerializerInterface $serializer): JsonResponse
    {
        $classes = $rep->findByEnseignant($id);
    
        $data = $serializer->serialize($classes, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId(); // retourne juste l'id au lieu de boucler
            },
        ]);
    
        return new JsonResponse($data, 200, [], true); // le dernier "true" indique que la donnée est déjà du JSON
    }
    
    #[Route('/api/enseignants/{id}/etudiants', name: 'api_enseignant_etudiants', methods: ['GET'])]
    public function getEtudiantsByEnseignant(
        int $id,
        EtudiantRepository $etudiantRepository
    ): JsonResponse {
        $etudiants = $etudiantRepository->findByEnseignant($id);
    
        return $this->json($etudiants);
    }


}
