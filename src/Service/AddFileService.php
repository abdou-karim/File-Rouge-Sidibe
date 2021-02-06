<?php
namespace App\Service;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Entity\CricterDadmissions;
use App\Entity\CricterDevaluations;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Type;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Referentiel;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddFileService
{
    private $request;
    private $manager;
    private $serializer;
    private $validator;
    private $promotionRepository;
    private $iriConverter;
public function __construct(EntityManagerInterface $manager,SerializerInterface $serializer,
                            ValidatorInterface $validator, PromotionRepository $promotionRepository,
                            IriConverterInterface $iriConverter){

    $this->manager=$manager;
    $this->serializer=$serializer;
    $this->validator=$validator;
    $this->promotionRepository = $promotionRepository;
    $this->iriConverter = $iriConverter;

}

public function AddFiles(Request $request){

    $referentiel=$request->request->all();
    $file=$request->files->get('programme');
    $referentielf =new Referentiel();
   // $referentielf = $this->serializer->denormalize($referentiel, "App\Entity\Referentiel", true);
    if (!$file) {

        return new JsonResponse("veuillez Ajouter Un Programme", Response::HTTP_BAD_REQUEST, [], true);
    }
    foreach ($referentiel as $key=>$value){

        if ($key === "cricterDevaluations"){
            foreach (json_decode($value) as $val){
                $crictEv = new CricterDevaluations();
                $crictEv->setLibelle($val);
                $this->manager->persist($crictEv);
                $referentielf->addCricterDevaluation($crictEv);
            }
        }
        if ($key === "cricterDadmissions"){
            foreach (json_decode($value) as $vall){
                $crictAd = new CricterDadmissions();
                $crictAd->setLibelle($vall);
                $this->manager->persist($crictAd);
                $referentielf->addCricterDadmission($crictAd);

            }
        }
        if( ($key==="libelle") || $key === "presentation"){
          $referentielf->{"set".ucfirst($key)}($value);
        }
//        if( $key==="promotion"){
//           foreach ($value as $nVal){
//
//               foreach ($this->iriConverter->getItemFromIri($nVal) as $p){
//               $referentielf->addPromotion($p);
//               }
//           }
//        }
        if ($key==="groupeCompetence" ){
            foreach (json_decode($value) as $vall){
                    $referentielf->addGroupeCompetence($this->iriConverter->getItemFromIri($vall));
            }
        }
    }
    $fileBlob=fopen($file->getRealPath(), "rb");
    $referentielf->setProgramme($fileBlob);
    $this->manager->persist($referentielf);
    $this->manager->flush();
    return new JsonResponse("success");

}

}
