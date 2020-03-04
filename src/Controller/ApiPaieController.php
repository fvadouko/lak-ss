<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\PointeusesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPaieController extends AbstractController
{
    /**
     * @Route("/api/paie", name="api_paie")
     */
    public function index()
    {
    }


    /**
     * @Route("/api/paie/findAll", name="findAllPaie" ,methods={"GET"})
     */
    public function findAll(
        PointeusesRepository $repoPointeuse,
        EntityManagerInterface $manager
    ) {
        $data = $repoPointeuse->findAllPaies($manager);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }
}
