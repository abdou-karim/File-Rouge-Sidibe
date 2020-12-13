<?php
namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\DenormalizedIdentifiersAwareItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Referentiel;
use App\Repository\ReferentielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ReferentielGetItemDataProvider implements ItemDataProviderInterface,RestrictedDataProviderInterface
{
    private $request;
    private $referentielRepository;
    public function __construct(RequestStack $requestStack,ReferentielRepository $referentielRepository){

        $this->request=$requestStack->getCurrentRequest();
        $this->referentielRepository=$referentielRepository;
}
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Referentiel::class=== $resourceClass;
    }

    /**
     * @inheritDoc
     */
    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $id2=intval($this->request->get('id2'));

        $comp=$this->referentielRepository->getCompetenceGroupeReferentiel($id,$id2);

        if($operationName==="GET_COMP_GP_REF"){

            return $comp;
        }

        if ($operationName==="GET_REF_GPC"){

            return $this->referentielRepository->findBy(['id'=>$id]);
        }

    }


}
