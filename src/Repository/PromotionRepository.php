<?php

namespace App\Repository;

use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Promotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotion[]    findAll()
 * @method Promotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    // /**
    //  * @return Promotion[] Returns an array of Promotion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Promotion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getApprenantByProfilSorties($idpromo){
        $query=$this
            ->createQueryBuilder('p')
            ->select('p,g,a,ps')
            ->andWhere('p.id=:idpromo')
            ->setParameter('idpromo',$idpromo)
            ->leftJoin('p.groupes','g')
            ->andWhere('g.typeDeGroupe=:type')
            ->setParameter('type','Groupe Principale')
            ->leftJoin('g.apprenants','a')
            ->leftJoin('a.profilSortie','ps')
            ->getQuery()
            ->getResult()[0]
            ->getGroupes()[0]
            ->getApprenants()


            ;


        return $query;
    }

    public function getApprenantsByPromoByOneProfilSortie($idpromo,$idprofilSortie){

        $query=$this
            ->createQueryBuilder('p')
            ->select('p,g,a,ps')
            ->andWhere('p.id=:idpromo')
            ->setParameter('idpromo',$idpromo)
            ->leftJoin('p.groupes','g')
            ->andwhere('g.typeDeGroupe=:type')
            ->setParameter('type','Groupe Principale')
            ->leftJoin('g.apprenants','a')
            ->leftJoin('a.profilSortie','ps')
            ->andWhere('ps.id=:idprofilSortie')
            ->setParameter('idprofilSortie',$idprofilSortie)
            ->getQuery()
            ->getResult()[0]
            ->getGroupes()[0]
            ->getApprenants()



        ;

        return $query;
    }
}
