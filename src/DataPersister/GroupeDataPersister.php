<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Groupe;
use App\Repository\ApprenantsRepository;
use App\Repository\GroupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class GroupeDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;
    private $request;
    private $groupeRepo;
    private $apprenantsRepo;
    public function __construct(EntityManagerInterface $entityManager ,RequestStack $requestStack,
                                GroupeRepository $groupeRepository,ApprenantsRepository $apprenantsRepository){

        $this->entityManager=$entityManager;
        $this->request=$requestStack->getCurrentRequest();
        $this->groupeRepo=$groupeRepository;
        $this->apprenantsRepo=$apprenantsRepository;
    }

    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {

       return $data instanceof Groupe;
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = [])
    {
        $data->setArchivage(false);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
        if ($context['iteme_operation_name']==="delete_apprenants"){


            $idApp=intval($this->request->get('ids'));

            $appren=$this->apprenantsRepo->findBy(['id'=>$idApp]);

            $data->removeApprenant($appren);

            $this->entityManager->persist($data);
        }

        $this->entityManager->flush();

    }
}
