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
       $data->setLibelle($data->getLibelle())
           ->setDescription($data->getDescription())
           ->setArchivage(false);
       $competnce =  $data->getCompetence();
       $tag = $data->getTags();
       foreach ($competnce as $value){
           $data->addCompetence($value);
           $value->setArchivage(false);
           $this->entityManager->persist($value);
       }
       if($tag){
           foreach ($tag as $value){
               $data->addTag($value);
               $this->entityManager->persist($value);
           }
       }

       $this->entityManager->persist($data);
       $this->entityManager->flush();
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
