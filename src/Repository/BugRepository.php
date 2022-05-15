<?php

namespace App\Repository;

use App\Entity\Bug;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bug|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bug|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bug[]    findAll()
 * @method Bug[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BugRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bug::class);
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function findAllByRecent(){
        return $this->createQueryBuilder('s')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ;
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function findAllPublishedByRecent(){
        return $this->createQueryBuilder('s')
            ->andWhere('s.published = true')
            ->orderBy('s.id', 'DESC')
            ->getQuery()
            ;
    }

    public function findByGameId($idGame)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.idGame = :val')
            ->setParameter('val', $idGame)
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByUserId($idUser)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.idGame = :val')
            ->setParameter('val', $idUser)
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBugsByTitleOrDescription(string $query)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('p.titleBug', ':query'),
                        $qb->expr()->like('p.descriptionTextBug', ':query'),
                    ),
                )
            )
            ->andWhere('p.published = true')
            ->orderBy('p.id', 'DESC')
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function searchDatas(Bug $searchBugs) {
        $query = $this->createQueryBuilder('a');

        if(!empty($searchBugs->getDescriptionTextBug())){
            $query = $query
                ->andWhere('a.descriptionTextBug LIKE :descriptionTextBug')
                ->setParameter('descriptionTextBug', '%'.$searchBugs->getDescriptionTextBug().'%');
        }
        if(!empty($searchBugs->getFrequencyBug())){
            $query = $query
                ->andWhere('a.frequencyBug LIKE :frequencyBug')
                ->setParameter('frequencyBug', '%'.$searchBugs->getFrequencyBug().'%');
        }
        if(!empty($searchBugs->getSeverityBug())){
            $query = $query
                ->andWhere('a.severityBug LIKE :severityBug')
                ->setParameter('severityBug', '%'.$searchBugs->getSeverityBug().'%');
        }
        if(!empty($searchBugs->getIdGame())){
            $query = $query
                ->andWhere('a.idGame LIKE :idGame')
                ->setParameter('idGame', '%'.$searchBugs->getIdGame().'%');
        }
        if(!empty($searchBugs->getIdBugFix())){
            $query = $query
                ->andWhere('a.idBugFix.resolved LIKE :idBugFix.resolved')
                ->setParameter('a.idBugFix.resolved', $searchBugs->getIdBugFix());
        }
        return $query->getQuery()->execute();
    }

    /**
     * @return Bug|null
     * @param string $value
     * @param $severityBug
     * @param $frequencyBug
     * @param $idGame
     * @param $idBugFix
     * @throws \Exception
     */
    public function findBySearch(string $value, $severityBug, $frequencyBug, $idGame, $idBugFix)

    {
        $query = $this->createQueryBuilder('a')
        ->addSelect('a')
        ->where('a.severityBug = :severityBug')
        ->andWhere('a.frequencyBug = :frequencyBug')
        ->andWhere('a.idGame = :idGame')
        ->andWhere('a.idBugFix = :idBugFix')
        ->andWhere('a.published = true')
        ->andWhere('a.titleBug LIKE :value')
        ->orWhere('a.descriptionTextBug LIKE :value')
        ->orderBy('a.id', 'DESC')
        ->setParameter(':value', $value)
        ->setParameter(':severityBug', $severityBug)
        ->setParameter(':frequencyBug', $frequencyBug)
        ->setParameter(':idGame', $idGame)
        ->setParameter(':idBugFix', $idBugFix)
        ->getQuery();

        try {
            return $query->getResult();
        }
        catch(\Exception $e) {
            throw new \Exception('problème '. $e->getMessage(). $e->getFile());
        }
    }

    // /**
    //  * @return Bug[] Returns an array of Bug objects
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
    public function findOneBySomeField($value): ?Bug
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
