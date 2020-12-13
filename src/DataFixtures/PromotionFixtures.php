<?php
namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Promotion;
use App\Repository\ApprenantsRepository;
use App\Repository\FormateursRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PromotionFixtures extends  Fixture
{
    private $apprenantsRepository;
    private $formateursRepository;
    public function __construct(ApprenantsRepository $apprenantsRepository, FormateursRepository $formateursRepository){

        $this->apprenantsRepository=$apprenantsRepository;
        $this->formateursRepository=$formateursRepository;
    }
    public static function getReferenceKey($i){
        return sprintf('promotion_user_%s',$i);
    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');

        $tabApp=$this->apprenantsRepository->findAll();
        $tabForm=$this->formateursRepository->findAll();





                for ($i=0;$i<=5;$i++){

                    $promotion=new Promotion();
                    $promotion->setTitre('promo#'.$i)
                        ->setLangue($fake->randomElement(['anglais','france']))
                        ->setFabrique($fake->randomElement(['Sonatel Académie','Simplon']))
                        ->setLieu("lieu".$i)
                        ->setStatus($fake->randomElement(['encours','ferme','attente']))
                        ->setDescription($fake->text.$i)
                        ->setDateFinProvisoire($fake->dateTimeBetween(+1))
                        ->setDateFinReelle($fake->dateTimeBetween(+1.5))
                        ->setDateDebut($fake->dateTimeBetween(+1));
                          foreach ($tabForm as $tabFormateur){

                              $promotion ->addFormateur($fake->unique(true)->randomElement($tabFormateur));
                          }
                    foreach ($tabApp as $tabApprenant){

                        $promotion ->addApprenant($fake->unique(true)->randomElement($tabApprenant));
                    }


                    for ($l=1;$l<=1;$l++){

                        $promotion->setReferentiel($this->getReference(ReferentielFixtures::getReferenceKey($i %1)));
                    }
                    $groupePrincipale=new Groupe();
                    $groupePrincipale->setNom('Groupe Principale '.$i)
                        ->setStatus($fake->randomElement(['encours','ferme','attente']))
                    ->setTypeDeGroupe('Groupe Principale')
                        ->setDateCreation($fake->dateTimeBetween(+1))
                        ->setArchivage(false)
                    ->setPromotion($promotion);

                    foreach ($tabApp as $tabApprenant){
                        $groupePrincipale->addApprenant($fake->unique(true)->randomElement($tabApprenant));
                    }

                    foreach ($tabForm as $tabFormateur){
                        $groupePrincipale->addFormateur($fake->unique(true)->randomElement($tabFormateur));
                    }
                    $manager->persist($promotion);
                    $manager->persist($groupePrincipale);
                    $this->addReference(self::getReferenceKey($i),$promotion);

                }
                $manager->flush();

    }


}
