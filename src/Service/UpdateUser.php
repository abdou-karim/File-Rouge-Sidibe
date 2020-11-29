<?php
namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UpdateUser
{
    private $encoder;
    private $serializer;
    private $validator;
    private $em;
    private $addUser;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        AddUser $addUser

    )
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
        $this->addUser=$addUser;
        $this->userReposirory=$userRepository;
    }
    public function ModifierUser(Request $request,int $id){

        $user=$this->userReposirory->find($id);
        $requestAll = $request->request->all();


       foreach ($requestAll as $key=>$value){

            if($key !=="_method" || !$value){

                $user->{"set".ucfirst($key)}($value);

            }
        }
        $photo=$request->files->get('photo');
        $photoBlob = fopen($photo->getRealPath(),"rb");

        if($photo){

            $user->setPhoto($photoBlob);
        }
        $errors = $this->validator->validate($user);
        if (count($errors)){
            $errors = $this->serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $this->em->persist($user);
        $this->em->flush();
        return new JsonResponse('success',Response::HTTP_OK);




    }

}
