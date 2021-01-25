<?php
namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Repository\ApprenantsRepository;
use App\Repository\FormateursRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class GroupeFixtures extends Fixture implements DependentFixtureInterface
{
    private $apprenantsRepository;
    private $formateursRepository;
    public function __construct(ApprenantsRepository $apprenantsRepository,FormateursRepository $formateursRepository){
        $this->apprenantsRepository=$apprenantsRepository;
        $this->formateursRepository=$formateursRepository;

    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');
        $apprenantAll=$this->apprenantsRepository->findAll();
        $formateurAll=$this->formateursRepository->findAll();


            for ($o=1;$o<=25;$o++){
                $tabApp[]=$apprenantAll[$o];
            }



        foreach ($formateurAll as $formt){

            $taF[]=$formt;
        }
        for ($i=1;$i<=4;$i++){

            $tabPromo[]=$this->getReference(PromotionFixtures::getReferenceKey($i));
        }

        foreach ($tabPromo as $item){
            $groupe=new Groupe();
            $groupe->setStatus($fake->randomElement(['encours','ferme']))
                ->setTypeDeGroupe($fake->randomElement(['binome','filerouge']))
                ->setDateCreation($fake->dateTimeBetween(+1))
                ->setArchivage(false)
                ->setPromotion($item);

            for ($b=1;$b<=5;$b++){


                $groupe->setNom('groupe'.$b);

                    for ($ap=1;$ap<=25;$ap++){

                        $groupe->addApprenant($fake->unique(true)->randomElement($tabApp));
                    }

                for($j=1, $jMax = 3; $j< $jMax; $j++)
                {
                    $groupe->addFormateur($fake->unique(true)->randomElement($taF));
                }
            }

        $manager->persist($groupe);
            $manager->flush();

        }
    }

    public function getDependencies()
    {
       return array(
         UserFixtures::class,
           PromotionFixtures::class
       );
    }
}
