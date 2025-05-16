<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Cours;
use App\Entity\Devoire;
use App\Entity\Enseignant;
use App\Repository\ClasseRepository;
use App\Repository\CommentaireRepository;
use App\Repository\DevoireRepository;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class EnginantController extends AbstractController
{
    
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/api/enseignant/{id}/classes', name: 'app_enseignant_classes', methods: ['GET'])]
    public function index(int $id, ClasseRepository $classeRepository, SerializerInterface $serializer): JsonResponse
    {
        $classes = $classeRepository->findByEnseignant($id);

        $data = $serializer->serialize($classes, 'json', [
            'circular_reference_handler' => fn($object) => $object->getId(),
        ]);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/api/enseignants/{id}/etudiants', name: 'api_enseignant_etudiants', methods: ['GET'])]
    public function getEtudiantsByEnseignant(int $id, EtudiantRepository $etudiantRepository): JsonResponse
    {
        $etudiants = $etudiantRepository->findByEnseignant($id);

        return $this->json($etudiants);
    }

    #[Route('/api/enseignant/{enseignantId}/classes/{classeId}/etudiants', name: 'api_enseignant_classes_etudiants', methods: ['GET'])]
public function getEtudiantsAndClasseDetailsByEnseignant(
    int $enseignantId,
    int $classeId,
    ClasseRepository $classeRepository,
    SerializerInterface $serializer
): JsonResponse {
    try {
        $classe = $classeRepository->find($classeId);

        if (!$classe) {
            return new JsonResponse(['error' => 'Classe non trouvée'], Response::HTTP_NOT_FOUND);
        }

        $enseignant = $classe->getEnseignant();

        // Gestion du cas où la classe n'a pas d'enseignant
        if (!$enseignant) {
            return new JsonResponse(['error' => 'Cette classe n\'a pas d\'enseignant assigné'], Response::HTTP_FORBIDDEN);
        }

        if ($enseignant->getId() !== $enseignantId) {
            return new JsonResponse(['error' => 'Accès interdit : cette classe n\'appartient pas à cet enseignant'], Response::HTTP_FORBIDDEN);
        }

        $etudiants = $classe->getEtudiant();

        $data = [
            'classe' => [
                'id' => $classe->getId(),
                'nom' => $classe->getNom(),
                'description' => $classe->getDescription(),
                'code' => $classe->getCode(),
                'createdAt' => $classe->getCreatedAt()->format('Y-m-d H:i:s'),
            ],
            'etudiants' => [],
        ];

        foreach ($etudiants as $etudiant) {
            $data['etudiants'][] = [
                'id' => $etudiant->getId(),
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom(),
                'email' => $etudiant->getEmail(),
                'imageProfile' => $etudiant->getImageProfile(),
            ];
        }

        $json = $serializer->serialize($data, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    } catch (\Exception $e) {
        return new JsonResponse(
            ['error' => 'Erreur serveur : ' . $e->getMessage()],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}


    #[Route('/api/addClasse', name: 'app_ajouter_classe', methods: ['POST'])]
    public function addClasse(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom'], $data['code'])) {
            return new JsonResponse(['message' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        $classe = new Classe();
        $classe->setNom($data['nom']);
        $classe->setCode($data['code']);
        $classe->setDescription($data['description'] ?? null);
        $classe->setImage($data['image'] ?? null);
        $classe->setCreatedAt(new \DateTimeImmutable());

        if (isset($data['enseignant_id'])) {
            $enseignant = $this->em->getRepository(Enseignant::class)->find($data['enseignant_id']);
            if (!$enseignant) {
                return new JsonResponse(['message' => 'Invalid enseignant_id'], Response::HTTP_NOT_FOUND);
            }
            $classe->setEnseignant($enseignant);
        }

        $this->em->persist($classe);
        $this->em->flush();

        return new JsonResponse(['message' => 'Classe ajoutée avec succès'], Response::HTTP_CREATED);
    }
        #[Route('/api/classes/{id}/cours', name: 'api_classe_cours', methods: ['GET'])]
    public function getCoursParClasse(int $id, ClasseRepository $classeRepository): JsonResponse
    {
        $classe = $classeRepository->find($id);

        if (!$classe) {
            return $this->json(['error' => 'Classe not found'], 404);
        }

        $cours = $classe->getCours();

        $data = [];
        foreach ($cours as $cour) {
            $data[] = [
                'id' => $cour->getId(),
                'titre' => $cour->getTitre(), // adapte selon les champs de l'entité Cours
                'description' => $cour->getDescription(),
                'createdAt' => $cour->getCreatedAt()?->format('Y-m-d H:i:s'),
            ];
        }

        return $this->json($data);
    }
   
    #[Route('/api/classe/{id}/commentaires', name: 'api_classe_commentaires', methods: ['GET'])]
public function getCommentairesByClasse(CommentaireRepository $commentaireRepository, int $id): JsonResponse
{
    $commentaires = $commentaireRepository->findCommentairesByClasseId($id);

    $data = [];
    foreach ($commentaires as $commentaire) {
        $etudiant = $commentaire->getEtudiant();
        $data[] = [
            'id' => $commentaire->getId(),
            'contenu' => $commentaire->getContenu(),
            'createdAt' => $commentaire->getCreatedAt()?->format('Y-m-d H:i:s'),
            'auteur' => $etudiant ? [
                'id' => $etudiant->getId(),
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom(),
                'email' => $etudiant->getEmail(),
                'imageProfile' => $etudiant->getImageProfile(),
            ] : null,
        ];
    }

    return $this->json($data);
}
#[Route('/api/cours', name: 'api_add_cours', methods: ['POST'])]
public function addCours(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $classe = $em->getRepository(Classe::class)->find($data['classe_id']);
    if (!$classe) {
        return new JsonResponse(['error' => 'Classe non trouvée'], 404);
    }

    $cours = new Cours();
    $cours->setTitre($data['titre']);
    $cours->setDescription($data['description']);
    $cours->setCreatedAt(new \DateTimeImmutable());
    $cours->setClasse($classe);

    if (!empty($data['devoire_id'])) {
        $devoir = $em->getRepository(Devoire::class)->find($data['devoire_id']);
        if ($devoir) {
            $cours->setDevoire($devoir);
        }
    }

    $em->persist($cours);
    $em->flush();

    return new JsonResponse(['message' => 'Cours ajouté avec succès'], 201);
}
#[Route('/api/classes', name: 'api_all_classes', methods: ['GET'])]
public function getAllClasses(ClasseRepository $classeRepository): JsonResponse
{
    $classes = $classeRepository->findAll();
    $data = [];

    foreach ($classes as $classe) {
        $data[] = [
            'id' => $classe->getId(),
            'nom' => $classe->getNom(),
            'code' => $classe->getCode(),
            'description' => $classe->getDescription(),
            'image' => $classe->getImage(),
        ];
    }

    return $this->json($data);
}

#[Route('/api/devoirs', name: 'api_add_devoir', methods: ['POST'])]
public function addDevoir(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    if (!isset($data['title'], $data['deadline'])) {
        return new JsonResponse(['error' => 'Champs obligatoires manquants (title, deadline)'], 400);
    }

    try {
        $devoir = new Devoire();
        $devoir->setTitle($data['title']);
        $devoir->setCreatedAt(new \DateTimeImmutable());

        // Convertir la deadline string en objet DateTimeImmutable
        $deadline = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['deadline']);
        if (!$deadline) {
            return new JsonResponse(['error' => 'Format de deadline invalide. Format attendu : Y-m-d H:i:s'], 400);
        }

        $devoir->setDeadline($deadline);

        $em->persist($devoir);
        $em->flush();

        return new JsonResponse(['message' => 'Devoir ajouté avec succès'], 201);
    } catch (\Exception $e) {
        return new JsonResponse(['error' => 'Erreur serveur : ' . $e->getMessage()], 500);
    }
}
   #[Route('/api/classes/{id}/devoirs', name: 'get_devoirs_by_classe', methods: ['GET'])]
    public function getDevoirsByClasse(int $id, ClasseRepository $classeRepository): Response
    {
        // Récupérer la classe par son id
        $classe = $classeRepository->find($id);

        if (!$classe) {
            return new JsonResponse(['message' => 'Classe non trouvée'], Response::HTTP_NOT_FOUND);
        }

        // Extraire tous les devoirs liés aux cours de cette classe
        $devoirs = [];

        foreach ($classe->getCours() as $cour) {
            $devoire = $cour->getDevoire();
            if ($devoire) {
                // Pour éviter les doublons, on vérifie si on l'a déjà ajouté
                if (!in_array($devoire, $devoirs, true)) {
                    $devoirs[] = $devoire;
                }
            }
        }

        // Transformer les devoirs en tableau simple (ex: id, title, deadline)
        $data = array_map(function($devoir) {
            return [
                'id' => $devoir->getId(),
                'title' => $devoir->getTitle(),
                'createdAt' => $devoir->getCreatedAt()->format('Y-m-d H:i:s'),
                'deadline' => $devoir->getDeadline()->format('Y-m-d H:i:s'),
            ];
        }, $devoirs);

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
