<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pointeuses;

use App\Repository\UserRepository;
use App\Repository\PointeusesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ApiPointeuseController extends AbstractController
{
    /**
     * @Route("/api/pointeuse", name="api_pointeuse")
     */
    public function index()
    {
        return $this->render('api_pointeuse/index.html.twig', [
            'controller_name' => 'ApiPointeuseController',
        ]);
    }

    /**
     * @Route("/api/create/pointeuses", name="addArrival" ,methods={"POST"})
     */
    public function store(
        UserRepository $repoUser,
        EntityManagerInterface $manager, 
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface,
        Request $request)
    {

        $data = \json_decode($request->getContent());
        //return new Response(json_encode($data->arrivals), 200, array('Content-Type' => 'application/json'));
        
        // $options = ['cost' => 10,];
        // $this->passwords = password_hash($passwords, PASSWORD_DEFAULT,$options);
        $passwords = $data->passwords;

        $user = $repoUser->findOneBy(['passwords' => $passwords]);

        $pointeuse = new Pointeuses();
        $pointeuse->setUser($user)
                ->setArrivals(new DateTime($data->arrivals))
                ->setDepartures($data->departures);
        $manager->persist($pointeuse);
        $manager->flush();

        return new Response(json_encode("success"), 200, array('Content-Type' => 'application/json'));
    }


    /**
     * @Route("/api/edit/pointeuses", name="addDepartures" ,methods={"POST"})
    */
    public function update(
        UserRepository $repoUser,
        PointeusesRepository $repoPointeuse,
        EntityManagerInterface $manager, 
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface,
        Request $request)
    {

        $data = \json_decode($request->getContent());
 
        // $options = ['cost' => 10,];
        // $this->passwords = password_hash($passwords, PASSWORD_DEFAULT,$options);
        $passwords = $data->passwords;
        
        $user = $repoUser->findOneBy(['passwords' => $passwords]);

        $pointeuse = $repoPointeuse->findOneBy(['user' => $user],['id'=>'DESC']);

        $pointeuse->setUser($user)
                ->setDepartures(new DateTime($data->departures))
                ->setWeek($data->week)
                ->setYear($data->year)
                ->setMonth($data->month);
        $manager->persist($pointeuse);
        $manager->flush();

        return new Response(json_encode("success"), 200, array('Content-Type' => 'application/json'));

    }  


        /**
        * @Route("/api/lastPointeuse/{password}", name="lastPointeuse" ,methods={"GET"})
        */
        public function lastPointeuse(
            UserRepository $repoUser,
            PointeusesRepository $repoPointeuse,
            $password,
            EntityManagerInterface $manager
        )

        {
    
            // $data = \json_decode($request->getContent());
     
            // $options = ['cost' => 10,];
            // $this->passwords = password_hash($passwords, PASSWORD_DEFAULT,$options);
            //$passwords = $data->passwords;
            
            $user = $repoUser->findOneBy(['passwords' => $password]);
            //$id = 131;
            $pointeuse = $repoPointeuse->lastPointeuse($manager,$user->getId());
    
            return new Response(json_encode($pointeuse), 200, array('Content-Type' => 'application/json'));
    
        } 
}
