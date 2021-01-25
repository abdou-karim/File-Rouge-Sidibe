<?php
namespace App\DataProvider;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Profil;
use App\Repository\ProfilsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class ProfilsGetCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface
{
    private $profilsRepository;
    private $paginationExtension;
    private $request;
    private $managerRegistry;
    public function __construct(ProfilsRepository $profilsRepository, RequestStack $requestStack,
                                PaginationExtension $paginationExtension,ManagerRegistry $managerRegistry){
        $this->profilsRepository=$profilsRepository;
        $this->request=$requestStack->getCurrentRequest();
        $this->paginationExtension=$paginationExtension;
        $this->managerRegistry = $managerRegistry;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {

        if ($operationName==="get_admin_profils_users"){

            return Profil::class === $resourceClass;
        }else{
            return false;
        }

    }
    /**
     * @inheritDoc
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        if($operationName==="get_admin_profils_users"){
            $myId=intval($this->request->get('id'));


            $manager = $this->managerRegistry->getManagerForClass($resourceClass);
            $repository = $manager->getRepository($resourceClass);
            $profilRepo = $repository->getUserByprofil($myId);
            $this->paginationExtension->applyToCollection($profilRepo, new QueryNameGenerator(), $resourceClass, $operationName,$context);
            if($profilRepo !== null){


                return $profilRepo->getQuery()->getOneOrNullResult()->getUser();
            }
      /*   dd($profilRepo->getQuery()->getOneOrNullResult());
            $repository->getUserByprofil($myId);
            $profils=$this->profilsRepository->getUserByprofil($myId);
            if($profils !==null){
                return $profils->getUser();;
            }*/


        }
    }


}
