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

class GroupeCompetenceController extends AbstractController
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

   /**
    * @Route(
    * name="Modifier_groupeCompetence",
    * path="/api/admin/groupe_competences/{id}",
    * methods={"PUT"}
*     )
    */
   public function ModifierGroupeCompetence(Request $request,int $id){

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

               if (isset($competence[$i]) && $this->competencesRepository->VerifieCompetence($competence[$i]['libelle'])!==null){

            $compte=1;
                   //Debut affectation


        $tabGroupe[]= $repoGroupeCompetence->addCompetence($this->competencesRepository->VerifieCompetence($competence[$i]['libelle']));

           /* $this->entityManager->persist($repoGroupeCompetence);
                 $this->entityManager->flush();*/

               //  return $this->json("Les Competences Sont affectés");
                   //return $compte;

                 //Fin affectation

               }else{
                   //Debut Ajout
                   /*$this->entityManager->persist($newCompetence);*/
                   //Verification niveau pour chaque Competence
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
                          /* $repoGroupeCompetence->addCompetence($newCompetence);
                           $this->entityManager->persist($niveau);
                           $this->entityManager->persist($repoGroupeCompetence);*/


                       }
                       $compte=2;
                            /*$this->entityManager->flush();*/

                      // return $this->json("Les Competences Sont Ajoutés") ;
                      // return $compte;
                       //Les Comptence qui ont 3 niveaux
                   }
                   elseif (count($competence[$i]['niveaux'])<3){

                       return $this->json($competence[$i]['libelle']." A moins de Trois Niveaux ");
                   }
                   else{

                       //Competence qui n'ont pas de niveau

                       return $this->json("Plus de Trois Niveaux ");
                   }

                   //Fin Ajout
               }

           }

           if ($compte===1){
               foreach ($tabGroupe as $value){

                   $this->entityManager->persist($value);
               }

               $this->entityManager->flush();
               dd($tabGroupe);

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

   }

}
