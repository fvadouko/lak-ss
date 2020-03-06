<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    // /**
    //  * @Route("/api/user/getUser/{id}", name="getUser" methods={"GET"})
    //  */
    // public function getUser(
    //     $id,
    //     UserRepository $repo
    // ){
    //     $user = $repo->find($id);
    //     return new Response(json_encode($user), 200, array('Content-Type' => 'application/json'));
    // }
}
