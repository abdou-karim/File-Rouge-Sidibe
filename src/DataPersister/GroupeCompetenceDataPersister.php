<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\GroupeCompetences;
use Doctrine\ORM\EntityManagerInterface;

class GroupeCompetenceDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager=$entityManager;
    }
    /**
     * @inheritDoc
     */
    public function supports($data, array $context = []): bool
    {
       return $data instanceof GroupeCompetences;
    }

    /**
     * @inheritDoc
     */
    public function persist($data, array $context = [])
    {
        // TODO: Implement persist() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($data, array $context = [])
    {
            $data->setArchivage(true);
            $this->entityManager->persist($data);
            $this->entityManager->flush();


    }
}
