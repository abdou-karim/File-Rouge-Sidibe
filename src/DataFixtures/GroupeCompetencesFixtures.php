<?php
namespace App\DataFixtures;

use App\Entity\GroupeCompetences;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class GroupeCompetencesFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');

        for ($g=1;$g<=13;$g++){
            $competence[]=$this->getReference(CompetencesFixtures::getReferenceKey($g));
        }

        for ($i=1;$i<=4;$i++){

            $groupeCompetences=new GroupeCompetences();
            $groupeCompetences->setLibelle($fake->realText($maxNBChars = 50, $indexSize = 2 ))
                ->setDescription($fake->realText());
            for ($c=1;$c<=3;$c++){

                $groupeCompetences->addCompetence($fake->unique(true)->randomElement($competence));

            }
               $manager->persist($groupeCompetences);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
      return  array(

          CompetencesFixtures::class,
      );
    }
}
