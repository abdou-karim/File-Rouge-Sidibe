<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Competences;
use Doctrine\ORM\EntityManagerInterface;

class CompetenceDataPersister implements ContextAwareDataPersisterInterface
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
      return $data instanceof Competences;
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
        $groupeCompetences=$data->getGroupeCompetences();
        $data->setArchivage(true);

        foreach ($groupeCompetences as $groupeCompetenc){

            $groupeCompetenc->removeCompetence($data);
            $this->entityManager->persist($groupeCompetenc);

        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();

    }
}
