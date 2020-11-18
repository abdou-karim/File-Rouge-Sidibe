<?php
namespace App\DataFixtures;
use App\Entity\Profils;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProfilFixtures extends Fixture
{

    public static function getReferenceKey($i){
        return sprintf('profil_user_%s',$i);
    }

    public function load(ObjectManager $manager)
    {
        $libelles=['Administrateur',"Formateur","Community Manager","Apprenant"];

            for ($i=0;$i<=3;$i++){
                $profil=new Profils();
                $profil->setLibelle($libelles[$i])
                    ->setArchivage(false);
                $manager->persist($profil);
                $this->addReference(self::getReferenceKey($i),$profil);

            }

            $manager->flush();





    }

}
