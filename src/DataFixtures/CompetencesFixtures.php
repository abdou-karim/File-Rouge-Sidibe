<?php
namespace App\DataFixtures;

use App\Entity\Competences;
use App\Entity\Niveau;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompetencesFixtures extends Fixture
{
    public static function getReferenceKey($i){
        return sprintf('competences_%s',$i);
    }
    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');

        for ($i=1;$i<=30;$i++){
            $competence=new Competences();
            $competence->setLibelle('libelle_'.$i)
                ->setDescription($fake->text);
            $this->addReference(self::getReferenceKey($i),$competence);
            $manager->persist($competence);

            for ($n=1;$n<=3;$n++){

                $niveau=new Niveau();
                $niveau->setLibelle('niveau_'.$n)
                    ->setCrictereDevaluation('CRICTERE '.$fake->realText())
                    ->setGroupeDaction('GROUPE ACTION'.$fake->realText())
                    ->setCompetence($competence);
                $manager->persist($niveau);
            }
        }
        $manager->flush();
    }

}
