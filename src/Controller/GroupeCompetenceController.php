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

       $competence=$requestAll['competence'];
           for($i=0, $iMax = count($competence); $i< $iMax; $i++){

               if (isset($competence[$i]) && $this->competencesRepository->VerifieCompetence($competence[$i]['libelle'])!==null){

                   //Debut affectation
                   $repoGroupeCompetence->addCompetence($this->competencesRepository->VerifieCompetence($competence[$i]['libelle']));



            $this->entityManager->persist($repoGroupeCompetence);
                 $this->entityManager->flush();

                 return $this->json("Les Competences Sont affectés");

                 //Fin affectation

               }else{
                   //Debut Ajout
                   $newCompetence=new Competences();
                   $newCompetence->setLibelle($competence[$i]['libelle'])
                       ->setDescription($competence[$i]['description']);

                   $this->entityManager->persist($newCompetence);
                   //Verification niveau pour chaque Competence
                   if(isset($competence[$i]['niveaux']) && count($competence[$i]['niveaux'])===3){

                       for ($n=0, $nMax = count($competence[$i]['niveaux']); $n< $nMax; $n++){

                           $niveau=new Niveau();
                           $niveau->setLibelle($competence[$i]['niveaux'][$n]['libelle'])
                               ->setGroupeDaction($competence[$i]['niveaux'][$n]['groupeDaction'])
                               ->setCrictereDevaluation($competence[$i]['niveaux'][$n]['crictereDevaluation'])
                               ->setCompetence($newCompetence);
                           $repoGroupeCompetence->addCompetence($newCompetence);
                           $this->entityManager->persist($niveau);
                           $this->entityManager->persist($repoGroupeCompetence);

                       }

                            $this->entityManager->flush();

                       return $this->json("Les Competences Sont Ajoutés");
                       //Les Comptence qui ont 3 niveaux
                   }else{

                       //Competence qui n'ont pas de niveau

                       return $this->json("Plus de Trois Niveaux ");
                   }

                   //Fin Ajout
               }

           }







   }
}
