<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Entity\Niveau;
use App\Repository\CompetencesRepository;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GroupeCompetenceController
{
    private $groupeCompetencesRepository;
    private $competencesRepository;
    private $manager;
    private $validator;
    public function __construct(GroupeCompetencesRepository $groupeCompetencesRepository,EntityManagerInterface $manager,
                                CompetencesRepository $competencesRepository,ValidatorInterface $validator){

        $this->groupeCompetencesRepository=$groupeCompetencesRepository;
        $this->entityManager=$manager;
        $this->competencesRepository=$competencesRepository;
        $this->validator=$validator;
    }


   public function ModifierGroupeCompetence(Request $request,int $id){

       //////////////////////////////////////////////
       /// MODIFICATION DE GROUPE DE COMPETENCE
       //////////////////////////////////////////////
       $repoGroupeCompetence=$this->groupeCompetencesRepository->find($id);
       $requestAll = json_decode($request->getContent(),true);
       $compte=0;

       if(isset($requestAll['libelle']) || isset($requestAll['description'])){

           $repoGroupeCompetence->setLibelle($requestAll['libelle'])
               ->setDescription($requestAll['description']);
           $this->entityManager->persist($repoGroupeCompetence);

       }

       $competence=$requestAll['competence'];

           for($i=0, $iMax = count($competence); $i< $iMax; $i++){

               if (isset($competence[$i]) && $this->competencesRepository->VerifieCompetence($competence[$i]['libelle'])!==null) {

                   $compte = 1;
                   ////////////////////////////////////////
                   // Debut affectation
                   /// //////////////////////////////////


                   $tabGroupe[] = $repoGroupeCompetence->addCompetence($this->competencesRepository->VerifieCompetence($competence[$i]['libelle']));

                   ///////////////////////////////////////////
                   /// DEBUT SUPPRESSION DE COMPETENCE
                   //////////////////////////////////////
                   if (isset($requestAll['action']) && $requestAll['action'] === "delete") {


                       $tabGroupeRemove[] = $this->competencesRepository->VerifieCompetence($competence[$i]['libelle']);


                       $compte = 3;
                   }
                   ///////////////////////////////////////////////
                   //FIN SUPPRESSION DE COMPETENCES
                   /////////////////////////////////////////////


               }else{

                   //////////////////////////////////////////////
                   /// DEBUT AJOUT DE COMPETENCE
                   /////////////////////////////////////////////
                   ///
                   if(isset($competence[$i]['niveaux']) && count($competence[$i]['niveaux'])===3){

                       for ($n=0, $nMax = count($competence[$i]['niveaux']); $n< $nMax; $n++){

                           $newCompetence=new Competences();
                           $tabComp[]=$newCompetence->setLibelle($competence[$i]['libelle'])
                               ->setDescription($competence[$i]['description']);

                         $niveau=new Niveau();
                          $tabN[]= $niveau->setLibelle($competence[$i]['niveaux'][$n]['libelle'])
                               ->setGroupeDaction($competence[$i]['niveaux'][$n]['groupeDaction'])
                               ->setCrictereDevaluation($competence[$i]['niveaux'][$n]['crictereDevaluation'])
                               ->setCompetence($newCompetence);

                       }
                       $compte=2;

                   }
                   elseif (isset($competence[$i]['niveaux']) && count($competence[$i]['niveaux'])>3){

                       return $this->json($competence[$i]['libelle']." Plus de Trois Niveaux ");
                   }
                   else{

                       //Competence qui n'ont pas de niveau

                       return $this->json("Moins de Trois Niveaux ajouter des niveaux");
                   }

                   /////////////////////////////////////////////////////
                   ///Fin Ajout
                   ////////////////////////////////////////////////////
               }

           }

           if ($compte===1){
               foreach ($tabGroupe as $value){

                   $this->entityManager->persist($value);
               }

               $this->entityManager->flush();


               return $this->json("Les Competences Sont affectés");
           }
           if($compte===2){

               foreach ($tabComp as $value){
                   $this->entityManager->persist($value);
               }

               $repoGroupeCompetence->addCompetence($newCompetence);
               foreach ($tabN as $value){
                   $this->entityManager->persist($value);
               }

               $this->entityManager->persist($repoGroupeCompetence);
               $this->entityManager->flush();

               return $this->json("Les Competences Sont Ajoutés");
           }
         if($compte===3){
              foreach ($tabGroupeRemove as $value){


                   $repoGroupeCompetence->removeCompetence($value);
                   $this->entityManager->persist($repoGroupeCompetence);
                   $this->entityManager->flush();

                   return $this->json("competence suprimmé");
               }
           }



   }

}
