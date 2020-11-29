<?php
namespace App\Service;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Repository\ProfilsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddUser
{
    private $encoder;
    private $serializer;
    private $validator;
    private $em;
    private $request;
    private $profilsRepository;

    public function __construct(

                                UserPasswordEncoderInterface $encoder,
                                SerializerInterface $serializer,
                                ValidatorInterface $validator,
                                EntityManagerInterface $em,
                                UserRepository $userRepository,
                                ProfilsRepository $profilsRepository,
                                IriConverterInterface $iriConverter
)
{

        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
        $this->userRepository=$userRepository;
        $this->profilsRepository=$profilsRepository;
        $this->iriConverter=$iriConverter;
    }

    public function addUser(Request $request)
    {
        $profilAll = $this->profilsRepository->findAll();

        foreach ($profilAll as $value) {

            $user = $request->request->all();

            
            $photo = $request->files->get("photo");
            $iriProfil = $this->iriConverter->getItemFromIri($user['profils'])->getLibelle();

            if ($iriProfil === $value = "Community Manager"){

                $user = $this->serializer->denormalize($user, "App\Entity\CommunityManager", true);

            } elseif ($iriProfil === $value = "Administrateur") {

                $user = $this->serializer->denormalize($user, "App\Entity\User", true);

            } elseif ($iriProfil === $value = "Formateur") {

                $user = $this->serializer->denormalize($user, "App\Entity\Formateurs", true);

            } elseif($iriProfil===$value="Apprenant") {

                $user = $this->serializer->denormalize($user, "App\Entity\Apprenants", true);
                $user->setProfilSortie($this->iriConverter->getItemFromIri($user['profilSortie']));
            }


            if (!$photo) {

                return new JsonResponse("veuillez mettre une images", Response::HTTP_BAD_REQUEST, [], true);
            }
            //$base64 = base64_decode($imagedata);
            $photoBlob = fopen($photo->getRealPath(), "rb");


            $user->setPhoto($photoBlob);

            $errors = $this->validator->validate($user);
            if (count($errors)) {
                $errors = $this->serializer->serialize($errors, "json");
                return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
            }

            $password = $user->getPlainPassword();
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $user->setArchivage(false);
            if ($this->encoder->encodePassword($user, $password)) {

                $this->em->persist($user);
                $this->em->flush();

                return new JsonResponse('Authenticated', Response::HTTP_OK);

            } else {

                return new JsonResponse(' username or password not work', Response::HTTP_INTERNAL_SERVER_ERROR);
            }


        }
    }
}
