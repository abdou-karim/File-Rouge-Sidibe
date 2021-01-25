<?php

namespace App\Repository;

use App\Entity\CricterDevaluations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CricterDevaluations|null find($id, $lockMode = null, $lockVersion = null)
 * @method CricterDevaluations|null findOneBy(array $criteria, array $orderBy = null)
 * @method CricterDevaluations[]    findAll()
 * @method CricterDevaluations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CricterDevaluationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CricterDevaluations::class);
    }

    // /**
    //  * @return CricterDevaluations[] Returns an array of CricterDevaluations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CricterDevaluations
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
