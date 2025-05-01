<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

//    /**
//     * @return Cours[] Returns an array of Cours objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cours
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findCoursByEnseignant($id)
{
    return $this->createQueryBuilder('c')
        ->select('c.titre', 'c.description', 'c.createdAt', 'cl.nom')
        ->join('c.classe', 'cl')                // relation vers Classe
        ->join('cl.enseignant', 'e')            // relation vers Enseignant
        ->where('e.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getArrayResult(); // ou ->getResult() si tu veux des objets
}

}
