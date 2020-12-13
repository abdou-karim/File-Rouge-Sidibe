<?php
namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagFixtures extends Fixture
{
    public static function getReferenceKey($i){

        return sprintf('tag_%s',$i);
    }


    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $fake=Factory::create('fr-FR');

        $tab=["HTML5", "php", "javascript", "angular", "wordpress", "bootstrap","json","python","java","joomla","c++","fortran","algo"];

        for($i=0, $iMax = count($tab); $i< $iMax; $i++)
        {
            $tag=new Tag();
            $tag->setLibelle($tab[$i]);
            $tag->setDescriptif("description ".$i);
            $this->addReference(self::getReferenceKey($i),$tag);
            $manager->persist($tag);
        }
        $manager->flush();
    }
}
