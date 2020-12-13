<?php
namespace App\Service;

use App\Entity\Promotion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Referentiel;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddFileService
{
    private $request;
    private $manager;
    private $serializer;
    private $validator;
public function __construct(EntityManagerInterface $manager,SerializerInterface $serializer,ValidatorInterface $validator){

    $this->manager=$manager;
    $this->serializer=$serializer;
    $this->validator=$validator;

}

public function AddFiles(Request $request){

    $referentiel=$request->request->all();
    $file=$request->files->get('programme');
    $referentiel = $this->serializer->denormalize($referentiel, Promotion::class, true);
    if (!$file) {

        return new JsonResponse("veuillez Ajouter Un Programme", Response::HTTP_BAD_REQUEST, [], true);
    }

    $fileBlob=fopen($file->getRealPath(), "rb");

    $referentiel->setProgramme($fileBlob);


    $this->manager->persist($referentiel);
    $this->manager->flush();

    return new JsonResponse("success");

}

}
