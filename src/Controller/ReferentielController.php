<?php

namespace App\Controller;

use App\Repository\ApprenantsRepository;
use App\Repository\ReferentielRepository;
use App\Service\AddFileService;
use App\Service\AddUser;
use App\Service\UpdateUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ReferentielController extends AbstractController
{

    private $addFil;
    private $apprenantsRepository;
    private $referentielRepository;
    private $entityManager;
    public function __construct(
      AddFileService $addFileService,
        ApprenantsRepository $apprenantsRepository,
        ReferentielRepository $referentielRepository,
        EntityManagerInterface $entityManager


    )
    {

        $this->addFil=$addFileService;
        $this->apprenantsRepository=$apprenantsRepository;
        $this->referentielRepository=$referentielRepository;
        $this->entityManager=$entityManager;

    }

     /**
      * @Route(
      *     name="addReferentiel",
      *     path="/api/admin/referentiels",
      *     methods={"POST"},
      *
      * ),
      */
     public function addReference(Request $request){

        return $this->addFil->AddFiles($request);
     }
    /**
     * @Route(
     *     name="addReferentiel",
     *     path="/api/admin/referentiels/{id}/apprenants",
     *     methods={"POST"},
     *
     * ),
     */
    public function addAndSendEmailApprenants(MailerInterface $mailer,Request $request,$id){
      $myRequest= json_decode($request->getContent(),true);
      $referentiel=$this->referentielRepository->findOneBy(['id'=>$id]);
        $email = (new Email())
            ->from('abdoukarimsidibe1@gmail.com');
        foreach ($myRequest['email'] as $value){
            $email->to($value);
            $email->subject('Welcome to the Space Bar!')
                ->text("Nice to meet you ! ❤️");
            $mailer->send($email);
            $apprenant= $this->apprenantsRepository->findOneBy(['email'=>$value]);
            $apprenant->setStatut('actif');
            $referentiel->addApprenant($apprenant);
            $this->entityManager->persist($referentiel);
            $this->entityManager->persist($apprenant);
        }
       $this->entityManager->flush();
        return new JsonResponse('succees');
    }
}
