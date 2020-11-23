<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Profils;
use Doctrine\ORM\EntityManagerInterface;





class ProfilsDataPersister implements DataPersisterInterface
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager=$entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data,   array $context = []): bool
    {
        return $data instanceof Profils;
    }

    /**
     * @param Profils $data
     * @param array $context
     */
    public function persist($data, array $context = [])
    {

        if ($data->getLibelle()) {
            $data->setLibelle($data->getLibelle());
            $data->setArchivage(false);
            $this->entityManager->persist($data);



        }
        $this->entityManager->flush();
            return $data;


    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {


        $users=$data->getUser();
        if($data->getArchivage()!==true){

            $data->setArchivage(true);

            if($users==null){

                $this->entityManager->persist($data);
                $this->entityManager->flush();
            }
            if($users!==null){

                foreach ($users as $user){
                    $user->setArchivage(true);
                    $this->entityManager->persist($data,$user);
                    $this->entityManager->flush();
                }
            }
        }




    }
}
