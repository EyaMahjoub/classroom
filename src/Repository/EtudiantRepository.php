<?php

namespace App\Repository;

use App\Entity\Etudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Etudiant>
 */
class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

//    /**
//     * @return Etudiant[] Returns an array of Etudiant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Etudiant
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findByEnseignant(int $enseignantId): array
{
    return $this->createQueryBuilder('e')
        ->join('e.classes', 'c')  // Jointure entre Etudiant et Classe via la table de jointure
        ->join('c.enseignant', 'ens')  // Jointure entre Classe et Enseignant
        ->andWhere('ens.id = :enseignantId')  // Filtre par l'ID de l'enseignant
        ->setParameter('enseignantId', $enseignantId)
        ->select('e.nom', 'e.prenom', 'e.email', 'e.imageProfile', 'c.nom AS classe')
        ->getQuery()
        ->getResult();
}
}
