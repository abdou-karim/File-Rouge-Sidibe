<?php
namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class PromotionGetItemDataProvider implements ItemDataProviderInterface,RestrictedDataProviderInterface
{
    private $promoRepo;
    private $request;
    public function __construct(PromotionRepository $promotionRepository,RequestStack $requestStack){

        $this->promoRepo=$promotionRepository;
        $this->request=$requestStack->getCurrentRequest();
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {

        if ($operationName==="promo_put_Ref" || $operationName==="promo_delete_add_apprenant"){

            return false;
        }else{
            return Promotion::class===$resourceClass;
        }

    }

    /**
     * @inheritDoc
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
       if($operationName==="get_Ref_Form_Gr"){

           return $this->promoRepo->findBy(['id'=>$id]);
       }
       if($operationName==="get_Ref_Form_App"){


           return $this->promoRepo->getRefFormApPri($id);
       }

       if($operationName==="get_Ref_Pr_GroupeComp_comp"){

           return $this->promoRepo->getRefPrGroupeCompComp($id);
       }
       if($operationName==="get_Referentiel_AppAttente"){

           return $this->promoRepo->getRefAppAttente($id);
       }
       if($operationName==="get_Pr_Gr_Ap_Ref_Ap"){


           $id2=intval($this->request->get('id2'));


           return $this->promoRepo->getPrGrApRefAp($id,$id2);
       }

       if($operationName==="get_form_ref_groupe"){

           return $this->promoRepo->findBy(['id'=>$id]);
       }

    }


}
