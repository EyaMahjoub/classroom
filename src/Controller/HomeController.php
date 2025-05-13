<?php

namespace App\Controller;


use App\Entity\Etudiant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EtudiantRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ClasseRepository;




class HomeController extends AbstractController
{
    #[Route('/etudiants/{id}/classesInscrit', name: 'etudiant_classes_inscrit', methods: ['GET'])]
    public function getThreeInscribedClasses(Etudiant $etudiant): JsonResponse
    {
        $classes = $etudiant->getClasses()->slice(0, 3);
        $data = [];

        foreach ($classes as $classe) {
            $data[] = [
                'id' => $classe->getId(),
                'nom' => $classe->getNom(),
                'description' => $classe->getDescription(),
                'creation' => $classe->getCreatedAt(),
                'image' => $classe->getImage()
            ];
        }

        return $this->json($data);
    }
    #[Route('/etudiants/{id}/classes-non-associees', name: 'etudiant_classes_non_associees')]
public function getTroisClassesNonAssociees(
    int $id,
    EtudiantRepository $etudiantRepository,
    ClasseRepository $classeRepository
): JsonResponse {
    $etudiant = $etudiantRepository->find($id);

    if (!$etudiant) {
        return $this->json(['message' => 'Étudiant non trouvé'], 404);
    }

    // Récupère les 3 premières classes associées à l'étudiant
    $classesInscrites = $etudiant->getClasses()->slice(0, 3);
    $idsInscrites = array_map(fn($classe) => $classe->getId(), $classesInscrites);

    // Récupère au maximum 3 classes non associées parmi ces 3 premières
    $classesNonAssociees = $classeRepository->createQueryBuilder('c')
        ->where('c.id NOT IN (:ids)')
        ->setParameter('ids', $idsInscrites ?: [0]) // éviter un tableau vide
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();

    // Formater les données pour la réponse
    $data = array_map(function ($classe) {
        return [
            'id' => $classe->getId(),
            'nom' => $classe->getNom(),
            'description' => $classe->getDescription(),
            'creation' => $classe->getCreatedAt(),
            'image' => $classe->getImage(),
        ];
    }, $classesNonAssociees);

    return $this->json($data);
}
#[Route('/etudiants/{id}/enseignants-inscrits', name: 'etudiant_enseignants_inscrits', methods: ['GET'])]
public function getFourEnseignantsFromEtudiantClasses(Etudiant $etudiant): JsonResponse
{
    $classes = $etudiant->getClasses();
    $enseignants = [];

    foreach ($classes as $classe) {
        $enseignant = $classe->getEnseignant();
        if ($enseignant && !in_array($enseignant, $enseignants, true)) {
            $enseignants[] = $enseignant;
        }
        if (count($enseignants) >= 4) {
            break;
        }
    }

    $data = [];
    foreach ($enseignants as $enseignant) {
        $data[] = [
            'id' => $enseignant->getId(),
            'nom' => $enseignant->getNom(),
            'email' => $enseignant->getEmail(), 
            'image' => $enseignant->getImageProfile(),
        ];
    }

    return $this->json($data);
}

}
