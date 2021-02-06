<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Entity\Referentiel;
use App\Repository\ApprenantsRepository;
use App\Repository\ReferentielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use DateTime;
class PromotionController extends AbstractController
{
    private $request;
    private $serializer;
    private $referentielRepository;
    private $apprenantsRepository;
    private $em;
    public function __construct(SerializerInterface $serializer,ApprenantsRepository $apprenantsRepository,
                                ReferentielRepository $referentielRepository, EntityManagerInterface $em)
    {
        $this->serializer=$serializer;
        $this->referentielRepository=$referentielRepository;
        $this->apprenantsRepository=$apprenantsRepository;
        $this->em=$em;
    }

    /**
     * @Route(
     *      name="post_promotion",
     *        path="/api/admin/promotions",
     *        methods={"POST"}
     * )
     */
    public function PostPromotion(Request $request)
    {
        //$promo = json_decode($request->getContent(),true);
        $promo = $request->request->all();
        $avatar=$request->files->get('avatar');

        $promotion = new Promotion();
       // $promotion = $this->serializer->denormalize($promo, Promotion::class, true);

        foreach ($promo as $key=>$value){
             if($key==="dateFinProvisoire" || $key==="dateDebut" || $key==="dateFinReelle"){
               $tab[]=$promotion->{"set".ucfirst($key)}(\DateTime::createFromFormat('Y-m-d',$value));

             }
             if ($key==="langue" || $key==="titre" || $key==="description" || $key==="lieu" || $key==="fabrique" || $key==="status"){
                $tab[] = $promotion->{"set".ucfirst($key)}($value);
             }
          /*   if($key ==="apprenants"){
                 foreach ($value as $val){
                   foreach ($val as $newval){
                       $promotion->addApprenant($this->apprenantsRepository->findOneBy(['id'=>$newval]));
                   }
                 }
             }*/
             if($key==="referentiels"){
                 foreach (json_decode($value) as $val){

                         $promotion->addReferentiel($this->referentielRepository->findOneBy(['id'=>$val]));
                 }
             }

        }
        if (!$avatar) {

            return new JsonResponse("veuillez Ajouter Un Avatar", Response::HTTP_BAD_REQUEST, [], true);
        }
        $avtarBlob=fopen($avatar->getRealPath(), "rb");
        $promotion->setAvatar($avtarBlob);
        $promotion->setStatus('encours');
        $this->em->persist($promotion);
        $this->em->flush();
        return new JsonResponse('success',201);
    }
}
