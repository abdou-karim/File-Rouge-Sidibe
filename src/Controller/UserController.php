<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
class UserController extends AbstractController
{
    private $encoder;
    private $serializer;
    private $validator;
    private $em;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $em)
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
    }

    /**
     * @Route(
     *     name="addUser",
     *     path="/api/admin/users",
     *     methods={"POST"},
     *
     * ),
     *   * @Route(
     *     name="addApprenants",
     *     path="/api/apprenants",
     *     methods={"POST"},
     *
     * ),   *   * @Route(
     *     name="addFormateur",
     *     path="/api/formateurs",
     *     methods={"POST"},
     *
     * ),
     */
    public function add(Request $request)
    {
        //recupéré tout les données de la requete
        $user = $request->request->all();
        //recupération de l'image
        $photo = $request->files->get("photo");
        if($user['profils']==="api/admin/profils/3"){

            $user = $this->serializer->denormalize($user,"App\Entity\CommunityManager",true);
        }
        elseif($user['profils']==="api/admin/profils/1"){
            $user = $this->serializer->denormalize($user,"App\Entity\User",true);
        }
        elseif($user['profils']==="api/admin/profils/2"){
            $user = $this->serializer->denormalize($user,"App\Entity\Formateurs",true);
        }
        else{

            $user = $this->serializer->denormalize($user,"App\Entity\Apprenants",true);
        }



       if(!$photo)
        {

            return new JsonResponse("veuillez mettre une images",Response::HTTP_BAD_REQUEST,[],true);
        }
        //$base64 = base64_decode($imagedata);
     $photoBlob = fopen($photo->getRealPath(),"rb");


        $user->setPhoto($photoBlob);

        $errors = $this->validator->validate($user);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }

      /*
        $user=new User();
        $user->setPassword($this->encoder->encodePassword($user,$password));
        */
        $password = $user->getPlainPassword();
       // $password="test";

        // User class based on symfony security User class
        $user->setPassword($this->encoder->encodePassword($user, $password));
        $user->setArchivage(false);
        if ($this->encoder->encodePassword($user, $password)) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return  $this->json('Authenticated',200);

        } else {

            return  $this->json(' username or password not work',400);
        }




    }

}
