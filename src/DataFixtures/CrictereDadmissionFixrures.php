<?php
namespace App\DataFixtures;


use App\Entity\CricterDadmissions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CrictereDadmissionFixrures extends Fixture
{
    public static function getReferenceKey($i){
        return sprintf('CrictereDadmission%s',$i);
    }
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        for ($i=1;$i<=10;$i++){
            $CrictereDadmission = new CricterDadmissions();
            $CrictereDadmission->setLibelle('CrictereDadmission'.$i);
            $this->addReference(self::getReferenceKey($i),$CrictereDadmission);
            $manager->persist($CrictereDadmission);
        }
        $manager->flush();
    }
}