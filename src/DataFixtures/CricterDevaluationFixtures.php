<?php
namespace App\DataFixtures;

use App\Entity\CricterDevaluations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CricterDevaluationFixtures extends Fixture
{
    public static function getReferenceKey($i){
        return sprintf('CricterDevaluation%s',$i);
    }


    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
       for ($i=1;$i<=10;$i++){
           $CricterDevaluation = new CricterDevaluations();
           $CricterDevaluation->setLibelle('CricterDevaluation_'.$i);
           $this->addReference(self::getReferenceKey($i),$CricterDevaluation);
           $manager->persist($CricterDevaluation);
       }
       $manager->flush();
    }
}