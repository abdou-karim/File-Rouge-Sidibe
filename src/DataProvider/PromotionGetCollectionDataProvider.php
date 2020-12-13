<?php
namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;

class PromotionGetCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface
{
    private $promotionRepository;
    public function __construct(PromotionRepository $promotionRepository){

        $this->promotionRepository=$promotionRepository;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
       return Promotion::class===$resourceClass;
    }

    /**
     * @inheritDoc
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {

     if($operationName==="get_R_F_G"){



         return $this->promotionRepository->getRefFormGroupes();
     }

     if ($operationName==="get_R_F_AGprincipal"){

           return  $this->promotionRepository->getRefFormAppGpr();
     }

     if($operationName==="get_Apprenant_Attente"){

         return $this->promotionRepository->getRefAppAttente();

     }
    }


}
