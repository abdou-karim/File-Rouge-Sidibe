<?php

namespace App\Controller;

use App\Service\AddFileService;
use App\Service\AddUser;
use App\Service\UpdateUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferentielController extends AbstractController
{

    private $addFil;
    public function __construct(
      AddFileService $addFileService


    )
    {

        $this->addFil=$addFileService;

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
}
