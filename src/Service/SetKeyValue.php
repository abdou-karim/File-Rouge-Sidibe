<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SetKeyValue
{
    private $manager;
    public function __construct(EntityManagerInterface $manager){
        $this->manager=$manager;
    }
    public function GetRequest(Request $request, $repositoryName, int $id)
    {


        $entityName=$this->manager->getRepository($repositoryName)->find($id);

        $requestAll=$request->request->all();

        foreach ($requestAll as $key=>$value){

            if($key !=="_method" || !$value){

              $s=  $entityName->{"set".ucfirst($key)}($value);

            }
        }

      return $s;



}
}
