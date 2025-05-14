<?php

namespace App\Controller;

use App\Entity\Fichier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FichierController extends AbstractController
{
    #[Route('/api/fichier', name: 'upload_fichier', methods: ['POST'])]
    public function upload(
        Request $request, 
        EntityManagerInterface $em
    ): JsonResponse
    {
        // 1. Validation du fichier
        $file = $request->files->get('file');
        if (!$file) {
            return new JsonResponse(['error' => 'Aucun fichier fourni'], Response::HTTP_BAD_REQUEST);
        }

        // 2. Validation du type de fichier
        $allowedMimeTypes = ['application/pdf'];
        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            return new JsonResponse(
                ['error' => 'Seuls les fichiers PDF sont autorisés'], 
                Response::HTTP_BAD_REQUEST
            );
        }

        // 3. Génération du nom de fichier sécurisé
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // 4. Déplacement du fichier
        try {
            $file->move(
                $this->getParameter('pdf_directory'),
                $fileName
            );
        } catch (FileException $e) {
            return new JsonResponse(
                ['error' => 'Erreur lors de l\'enregistrement du fichier: '.$e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        // 5. Création de l'entité Fichier
        $fichier = new Fichier();
        $fichier->setUrl($fileName)
                ->setType('pdf')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setClasse(null); // Explicitement défini à null

        $em->persist($fichier);
        $em->flush();

        return new JsonResponse(
            [
                'success' => true,
                'fileName' => $fileName,
                'id' => $fichier->getId()
            ], 
            Response::HTTP_CREATED
        );
    }
}