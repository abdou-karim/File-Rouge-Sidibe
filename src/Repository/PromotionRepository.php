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

    public function getRefFormGroupes(){
        $query=$this->createQueryBuilder('p')
            ->select('p,r,g,f')
            ->leftJoin('p.referentiel','r')
            ->leftJoin('p.groupes','g')
            ->andWhere('g.archivage=:statutArchivage')
            ->setParameter('statutArchivage',0)
            ->leftJoin('p.formateurs','f')
            ->andWhere('f.archivage=:stautf')
            ->setParameter('stautf',0)
            ->getQuery()
            ->getResult()
            ;

        return $query;

    }

    public function getRefFormAppGpr(){
        $query=$this->createQueryBuilder('p')
            ->select('p,r,g,a')
            ->leftJoin('p.referentiel','r')
            ->leftJoin('p.groupes','g')
            ->andWhere('g.typeDeGroupe=:type')
            ->setParameter('type','Groupe Principale')
            ->leftJoin('g.apprenants','a')
            ->andWhere('a.statut=:stat')
            ->setParameter('stat','actif')
            ->getQuery()
            ->getResult()
            ;

        return $query;
    }

    public function getRefAppAttente($id=null){

        $query=$this->createQueryBuilder('p')
            ->select('p,r,a')
            ->leftJoin('p.referentiel','r')
            ->leftJoin('p.apprenants','a')
            ->andWhere('a.statut=:sat')
            ->setParameter('sat','attente')

            ;
        if ($id){
            $query->andWhere('p.id=:idpromo')
                ->setParameter('idpromo',$id)

                ;

        }
        return $query->getQuery()
                    ->getResult();

    }


    public function getRefFormApPri($id){

        $query=$this->createQueryBuilder('p')
            ->select('p,r,g,a')
            ->andWhere('p.id=:idPromo')
            ->setParameter('idPromo',$id)
            ->leftJoin('p.referentiel','r')
            ->leftJoin('p.groupes','g')
            ->andWhere('g.typeDeGroupe=:statuts')
            ->setParameter('statuts','Groupe Principale')
            ->leftJoin('g.apprenants','a')
            ->andWhere('a.statut=:sta')
            ->setParameter('sta','actif')
            ->getQuery()
            ->getResult()

            ;


        return $query;

    }

    public function getRefPrGroupeCompComp($id){

        $query=$this->createQueryBuilder('p')
            ->select('p,r,gr,c')
            ->andWhere('p.id=:idpromo')
            ->setParameter('idpromo',$id)
            ->leftJoin('p.referentiel','r')
            ->leftJoin('r.groupeCompetence','gr')
            ->leftJoin('gr.competence','c')
            ->getQuery()
            ->getResult()
            ;
        return $query;

    }

    public function getPrGrApRefAp($idPromo,$idGroupe){
        $query=$this->createQueryBuilder('p')
            ->select('p,r,g,a,ap')
            ->andWhere('p.id=:idPromo')
            ->setParameter('idPromo',$idPromo)
            ->leftJoin('p.referentiel','r')
            ->leftJoin('p.apprenants','a')
            ->leftJoin('p.groupes','g')
            ->andWhere('g.id=:idGrou')
            ->setParameter('idGrou',$idGroupe)
            ->leftJoin('g.apprenants','ap')
            ->andWhere('ap.statut=:st')
            ->setParameter('st','actif')
            ->getQuery()
            ->getResult()
            ;

        return $query;

    }
}
