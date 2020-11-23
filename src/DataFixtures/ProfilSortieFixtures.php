<?php
namespace App\DataFixtures;
use App\Entity\ProfilSortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
class ProfilSortieFixtures extends Fixture

{

    public static function getReferenceKey($i){
        return sprintf('profil_sorti_user_%s',$i);
    }

    public function load(ObjectManager $manager){

        $ProfilSortis = ["Développeur front", "back", "fullstack", "CMS", "intégrateur", "designer", "CM", "Data"];

        for ($i=0;$i<8;$i++){
            $Unprofil=new ProfilSortie();
            $Unprofil->setLibelle($ProfilSortis[$i])
                ->setArchivage(false);
            $manager->persist($Unprofil);
            $this->addReference(self::getReferenceKey($i),$Unprofil);
        }


        $manager->flush();


    }

}
