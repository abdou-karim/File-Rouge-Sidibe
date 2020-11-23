<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\ProfilSortie;
use Doctrine\ORM\EntityManagerInterface;

class ProfilSortiesDataPersister implements ContextAwareDataPersisterInterface{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager=$entityManager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof ProfilSortie;
    }

    public function persist($data, array $context = [])
    {
        if($data->getLibelle()){
            $data->setLibelle($data->getLibelle());
            $data->setArchivage(false);
            $this->entityManager->persist($data);
        }
        $this->entityManager->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {

       if($data->getArchivage()!==true){
                    $data->setArchivage(true);
               $this->entityManager->persist($data);
               $this->entityManager->flush();

       }
    }
}
