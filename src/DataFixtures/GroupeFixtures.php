<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class GroupeFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {


    }

    public function getDependencies()
    {
       return array(
         UserFixtures::class,
           PromotionFixtures::class
       );
    }
}
