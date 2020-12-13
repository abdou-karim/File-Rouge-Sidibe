<?php
namespace App\DataFixtures;

use App\Entity\Referentiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReferentielFixtures extends Fixture
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

        for ($i=0;$i<5;$i++){

            $referentiel=new Referentiel();
            $referentiel->setLibelle('Referentiel no °:'.$i)
                ->setCrictereAdmission("Crictere adminssion ".$i)
                ->setCrictereEvaluation("Crictere Evaluation ".$i)
                ->setProgramme($fake->imageUrl())
                ->setPresentation("presentation ".$i);
            $this->addReference(self::getReferenceKey($i),$referentiel);

            $manager->persist($referentiel);

        }
        $manager->flush();
    }
}
