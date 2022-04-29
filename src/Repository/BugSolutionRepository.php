<?php

namespace App\Repository;

use App\Entity\BugSolution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BugSolution|null find($id, $lockMode = null, $lockVersion = null)
 * @method BugSolution|null findOneBy(array $criteria, array $orderBy = null)
 * @method BugSolution[]    findAll()
 * @method BugSolution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BugSolutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BugSolution::class);
    }

    public function findByBugId($idBug)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.idBug = :val')
            ->setParameter('val', $idBug)
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return BugSolution[] Returns an array of BugSolution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BugSolution
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
