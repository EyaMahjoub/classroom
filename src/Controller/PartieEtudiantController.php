<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Etudiant;
use App\Repository\ClasseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
final class PartieEtudiantController extends AbstractController
{
    #[Route('/etudiants/{id}/classes', name: 'etudiant_classes', methods: ['GET'])]
    public function getClassesEtudiant(Etudiant $etudiant): JsonResponse
    {
        $classes = $etudiant->getClasses();
        $data = [];

        foreach ($classes as $classe) {
            $data[] = [
                'id' => $classe->getId(),
                'nom' => $classe->getNom(),
                'description'=>$classe->getDescription(),
                'creation'=>$classe->getCreatedAt(),
                'image'=>$classe->getImage()
            ];
        }

        return $this->json($data);
}
#[Route('/classes/{id}/cours', name: 'cours', methods: ['GET'])]
    public function getCoursEtudiant(Classe $classe): JsonResponse
    {
        $cours = $classe->getCours();
        $data = [];

        foreach ($cours as $cour) {
            $data[] = [
                'id' => $cour->getId(),
                'nom' => $cour->getTitre(),
                'creation'=>$cour->getCreatedAt(),
                'description'=>$cour->getDescription()
            ];
        }

        return $this->json($data);
}
#[Route('/enseignant/{id}', name: 'enseignant', methods: ['GET'])]
    public function getenseignant(Classe $classe): JsonResponse
    {
        $enseignant = $classe->getEnseignant();
        $data = [];
            $data[] = [
                'id' => $enseignant->getId(),
                'nom' => $enseignant->getNom(),
                'prenom'=>$enseignant->getPrenom(),
                'image'=>$enseignant->getImageProfile()
            ];
        

        return $this->json($data);
}
#[Route('/classes/{id}', name: 'etudiant', methods: ['GET'])]
    public function getEtudiant(Classe $classe): JsonResponse
    {
        $etudiants = $classe->getEtudiant();
        $data = [];

        foreach ($etudiants as $etudiant) {
            $data[] = [
                'id' => $etudiant->getId(),
                'nom' => $etudiant->getNom(),
                'prenom'=>$etudiant->getPrenom(),
                'image'=>$etudiant->getImageProfile()
            ];
        }

        return $this->json($data);
}
}