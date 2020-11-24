<?php

namespace App\Controller;

use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProfilSortiesController extends AbstractController
{
    private $promotionRepository;
    private $serializer;
    public function __construct(PromotionRepository $promotionRepository, SerializerInterface $serializer){
        $this->promotionRepository=$promotionRepository;
        $this->serializer=$serializer;
    }
/**
 * @Route(
 *         name="get_Appreant_ProilSorti",
 *        path="/api/admin/promo/{idpromo}/profilsorties",
 *        methods={"GET"}
 *     )
 */
public function getApprenantsProfilSorties(int $idpromo){

    $apprenat=$this->promotionRepository->getApprenantByProfilSorties($idpromo);

  return $this->json($apprenat,200);
}

/**
 * @Route (
 *     name="get_Apprenant_One_Promo_One_profilSortie",
 *     path="/api/admin/promo/{idpromo}/profilsorties/{idprofilSortie}",
 *      methods={"GET"}
 * )
 */
 public function getApprenantOnePromoOneProfilSortie(int $idpromo,int $idprofilSortie)
 {
     $apprenant=$this->promotionRepository->getApprenantsByPromoByOneProfilSortie($idpromo,$idprofilSortie);
   return $this->json($apprenant,200);
 }
}
