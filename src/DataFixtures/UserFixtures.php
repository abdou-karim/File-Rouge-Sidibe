<?php
namespace App\DataFixtures;

use App\Entity\Apprenants;
use App\Entity\CommunityManager;
use App\Entity\Formateurs;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public static function addApprenantGroupe($i){
        return sprintf('add_apprenant_%s',$i);
    }
    public static function addFormateurGroupe($g){
        return sprintf('add_formateur_%s',$g);
    }

    private $encode;
    protected $profilRepositiry;
    public function __construct(UserPasswordEncoderInterface $encode)
    {
        $this->encode=$encode;
    }



    public function load(ObjectManager $manager)

    {
        $fake = Factory::create('fr-FR');
            for($i=0;$i<=3;$i++){

                $nbrUser=5;
                $userProfil=$this->getReference(ProfilFixtures::getReferenceKey($i %4));
               // $UserProfilSorti=$this->getReference(ProfilSortieFixtures::getReferenceKey($i %8));


                if($userProfil->getLibelle() ==="Apprenant"){
                    $nbrUser=100;
                }

                for ($b=0;$b<$nbrUser;$b++){

                    $user=new User();

                    if($userProfil->getLibelle()==="Apprenant"){

                        $user=new Apprenants();
                        $user->setGenre($fake->randomElement(['homme','femme']))
                            ->setTelephone($fake->phoneNumber())
                            ->setAdresse($fake->address())
                            ->setProfilSortie($this->getReference(ProfilSortieFixtures::getReferenceKey($b %8)));
                        $this->addReference(self::addApprenantGroupe($b),$user);

                    }
                    if($userProfil->getLibelle()==="Formateur"){
                        $user=new Formateurs();
                                $this->addReference(self::addFormateurGroupe($b),$user);
                    }
                    if($userProfil->getLibelle()==="Community Manager"){
                        $user=new CommunityManager();
                    }
                    $user->setProfils($userProfil)
                        ->setUsername( strtolower ($fake->userName))
                        ->setFisrtname($fake->firstName)
                        ->setLastname($fake->lastName)
                        ->setEmail($fake->email)
                        ->setArchivage(false);
                    $photo = fopen($fake->imageUrl($width = 640, $height = 480),'rb');
                    //$photo = $fake->imageUrl($width = 640, $height = 480);
                    $user->setPhoto($photo);
                    $password = $this->encode->encodePassword ($user, 'Sidibe123' );
                    $user->setPassword($password);
                    $manager->persist($user);
                }
            }
            $manager->flush();

    }
    public function getDependencies()
    {
        return array(
            ProfilFixtures::class,
        );
    }

}
