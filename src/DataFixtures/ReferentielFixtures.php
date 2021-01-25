<?php
namespace App\DataFixtures;

use App\Entity\Referentiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReferentielFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceKey($i){
        return sprintf('referentiel_%s',$i);
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $fake=Factory::create('fr-FR');
        for ($k=1;$k<=10;$k++){
            $tabCricterDadmission[] = $this->getReference(CrictereDadmissionFixrures::getReferenceKey($k)) ;
        }
     for ($l=1;$l<=10;$l++){
         $tabCricterDevaluation[] = $this->getReference(CricterDevaluationFixtures::getReferenceKey($l));
     }

        for ($i=1;$i<=5;$i++){

            $referentiel=new Referentiel();
            $referentiel->setLibelle('Referentiel no °:'.$i)
                ->setProgramme($fake->imageUrl())
                ->setPresentation("presentation ".$i);
            for ($n=1;$n<=2;$n++){
                $referentiel->addCricterDadmission($fake->unique(true)->randomElement($tabCricterDadmission));
            }
            for ($n=1;$n<=2;$n++){
                $referentiel->addCricterDevaluation($fake->unique(true)->randomElement($tabCricterDevaluation));
            }
            $manager->persist($referentiel);
            $this->addReference(self::getReferenceKey($i),$referentiel);

        }
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return array(
            CrictereDadmissionFixrures::class,
            CricterDevaluationFixtures::class,
        );
    }
}
