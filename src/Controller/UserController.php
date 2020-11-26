<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\AddUser;
use App\Service\UpdateUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class UserController extends AbstractController
{


    private $updateUser;
    private $addUser;
    private $userRepository;
    public function __construct(
        AddUser $addUser,
        UpdateUser $updateUser


)
    {

        $this->addUser=$addUser;
        $this->updateUser=$updateUser;
       // $this->userRepo=$userRepository;
    }

    /**
     * @Route(
     *     name="addUser",
     *     path="/api/admin/users",
     *     methods={"POST"},
     *
     * ),
     *   * @Route(
     *     name="addApprenants",
     *     path="/api/apprenants",
     *     methods={"POST"},
     *
     * ),   *   * @Route(
     *     name="addFormateur",
     *     path="/api/formateurs",
     *     methods={"POST"},
     *
     * ),
     */
    public function add(Request $request)
    {
       return $this->addUser->addUser($request);



    }
    /**
     * @Route(
     *     name="updateUser",
     *     path="/api/admin/users/{id}",
     *     methods={"PUT"},
     * ),  * @Route(
     *     name="updateApprenant",
     *     path="/api/apprenants/{id}",
     *     methods={"PUT"},
     * ), * @Route(
     *     name="updateFormateur",
     *     path="/api/formateurs/{id}",
     *     methods={"PUT"},
     * ),
    */
    public function UpdateUser(Request $request,int $id){

    return $this->updateUser->ModifierUser($request,$id);
    }

}
