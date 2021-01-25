<?php
namespace App\DataFixtures;

use App\Entity\GroupeCompetences;
use App\Repository\TagRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class GroupeCompetencesFixtures extends Fixture implements DependentFixtureInterface
{
    private $tagRepository;
public function __construct(TagRepository $tagRepository){
    $this->tagRepository=$tagRepository;
}

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');

        $tabTa=$this->tagRepository->findAll();

        foreach ($tabTa as $tabTag){
            $tabTAG[]=$tabTag;
        }

        for ($g=1;$g<=30;$g++){
            $competence[]=$this->getReference(CompetencesFixtures::getReferenceKey($g));

        }


        for ($i=1;$i<=6;$i++){

            $groupeCompetences=new GroupeCompetences();
            $groupeCompetences->setLibelle($fake->realText($maxNBChars = 50, $indexSize = 2 ))
                ->setDescription($fake->realText())
                ->setArchivage(false);
            for ($c=1;$c<=3;$c++){

                $groupeCompetences->addCompetence($fake->unique(true)->randomElement($competence));

            }
            for ($t=1;$t<=5;$t++){
                $groupeCompetences->addTag($fake->unique(true)->randomElement($tabTAG));
            }

        }
        for ($l=1;$l<=2;$l++){

            $groupeCompetences->addReferentiel($this->getReference(ReferentielFixtures::getReferenceKey($l)));
        }
        $manager->persist($groupeCompetences);
        $manager->flush();
    }

    public function getDependencies()

    {
      return  array(

          CompetencesFixtures::class,
          TagFixtures::class,
          ReferentielFixtures::class,
          );
    }
}
