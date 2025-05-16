<?php

namespace App\Controller;

use App\Entity\Fichier;
use App\Entity\Classe;
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

        // 3. Récupération de l'ID de la classe
        $classeId = $request->request->get('classeId');
        if (!$classeId) {
            return new JsonResponse(
                ['error' => 'ID de classe manquant'], 
                Response::HTTP_BAD_REQUEST
            );
        }

        $classe = $em->getRepository(Classe::class)->find($classeId);
        if (!$classe) {
            return new JsonResponse(
                ['error' => 'Classe non trouvée'], 
                Response::HTTP_NOT_FOUND
            );
        }

        // 4. Génération du nom de fichier
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // 5. Déplacement du fichier
        try {
            $file->move(
                $this->getParameter('pdf_directory'),
                $fileName
            );
        } catch (FileException $e) {
            return new JsonResponse(
                ['error' => 'Erreur lors de l\'enregistrement du fichier'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        // 6. Création de l'entité Fichier
        $fichier = new Fichier();
        $fichier->setUrl($fileName)
                ->setType('pdf')
                ->setCreatedAt(new \DateTimeImmutable())
                ->setClasse($classe)
              ;

        $em->persist($fichier);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'fileName' => $fileName,
            'id' => $fichier->getId(),
            'classeId' => $classe->getId()
        ], Response::HTTP_CREATED);
    }
}