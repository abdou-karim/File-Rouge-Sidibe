<?php

use App\DataFixtures\TagFixtures;
use App\Entity\GroupeTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GroupeTagFixtures extends  Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
       for ($i=0;$i<13;$i++){
           $tag[]=$this->getReference(TagFixtures::getReferenceKey($i));
       }

       for($i=1;$i<=5;$i++){

           $groupeTag=new GroupeTag();
           $groupeTag->setLibelle('libelle'.$i);

           for ($g=1;$g<=4;$g++){
            $groupeTag->addTag($tag);

           }
           $manager->persist($groupeTag);
       }
            $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return array(TagFixtures::class);
    }
}
