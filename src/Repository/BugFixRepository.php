<?php

namespace App\Repository;

use App\Entity\BugFix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BugFix|null find($id, $lockMode = null, $lockVersion = null)
 * @method BugFix|null findOneBy(array $criteria, array $orderBy = null)
 * @method BugFix[]    findAll()
 * @method BugFix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BugFixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BugFix::class);
    }


    // /**
    //  * @return BugFix[] Returns an array of BugFix objects
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
    public function findOneBySomeField($value): ?BugFix
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
