<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use App\Repository\ReferentielRepository;
use App\Service\AddFileService;
use Doctrine\ORM\EntityManagerInterface;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PromotionDataPersister implements ContextAwareDataPersisterInterface
{
    private $manager;
    private $request;
    private $promoRepo;
    private $addFil;
    private $referentielRepository;
    public function __construct(EntityManagerInterface $manager, RequestStack $requestStack,
                                PromotionRepository $promotionRepository,AddFileService $addFileService,
                                ReferentielRepository $referentielRepository){
        $this->manager=$manager;
        $this->request=$requestStack->getCurrentRequest();
        $this->promoRepo=$promotionRepository;
        $this->addFil=$addFileService;
        $this->referentielRepository=$referentielRepository;


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



        if($context["collection_operation_name"]==="POST"){
            $referentiel= $data->getReferentiels();
            dd($referentiel);
            $this->manager->persist($data);
            $this->manager->flush();
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
