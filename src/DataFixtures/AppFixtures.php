<?php

namespace App\DataFixtures;

use App\Entity\Apprenants;
use App\Entity\CommunityManager;
use App\Entity\Formateurs;
use App\Entity\Profil;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {

        $manager->flush();
    }
}
