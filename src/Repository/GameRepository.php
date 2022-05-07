<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findByBugId($bugs): ?Game
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.bugs = :val')
            ->setParameter('val', $bugs)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findByEditorId($idEditor)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.idEditor = :val')
            ->setParameter('val', $idEditor)
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllBugFromSingleGame(){

        /*$query = $em->createQuery('SELECT u, p FROM Game u JOIN u.Bug p');
        $game = $query->getResult(); // array of CmsUser objects with the phonenumbers association loaded
        $numberOfBugs = $this->count($game);*/
    }

    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
