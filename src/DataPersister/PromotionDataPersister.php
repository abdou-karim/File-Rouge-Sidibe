<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use App\Service\AddFileService;
use Doctrine\ORM\EntityManagerInterface;



use Symfony\Component\HttpFoundation\RequestStack;

class PromotionDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    private $request;
    private $promoRepo;
    private $addFil;
    public function __construct(EntityManagerInterface $manager, RequestStack $requestStack,
                                PromotionRepository $promotionRepository,AddFileService $addFileService){
        $this->manager=$manager;
        $this->request=$requestStack->getCurrentRequest();
        $this->promoRepo=$promotionRepository;
        $this->addFil=$addFileService;


    }

    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Promotion;
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = [])
    {



        if($context["item_operation_name"]==="promo_delete_add_apprenant"){

        }
        if ($context['item_operation_name']==="promo_put_Ref"){

          $this->addFil->AddFiles($this->request);
        }

    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}
