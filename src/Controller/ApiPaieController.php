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
        return $this->render('api_paie/index.html.twig', [
            'controller_name' => 'ApiPaieController',
        ]);
    }


    // /**
    //  * @Route("/api/paie/findAll", name="findAllPaie" ,methods={"GET"})
    //  */
    // public function findAll(
    //     PointeusesRepository $repoPointeuse,
    //     EntityManagerInterface $manager)
    // {
    //     $data = $repoPointeuse->findAllPaies($manager);
    //     return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    // }

    // /**
    //  * @Route("/api/paie/findAll", name="findAllPaie" ,methods={"POST"})
    //  */
    // public function findAll(
    //     PointeusesRepository $repoPointeuse,
    //     Request $request,
    //     EntityManagerInterface $manager)
    // {
    //     $data = \json_decode($request->getContent());

    //     $year = $data->year;
    //     $month = $data->month;

    //     $data = $repoPointeuse->findAllPaies($manager,$year,$month);
    //     return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    // }

    /**
     * @Route("/api/paie/findAll/{year}/{month}", name="findAllPaie" ,methods={"GET"})
     */
    public function findAll(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->findAllPaies($manager,$year,$month);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }

    // /**
    //  * @Route("/api/paie/findPaieByUser/{year}/{month}/{id}", name="findPaieByUser" ,methods={"GET"})
    //  */
    // public function findPaieByUser(
    //     PointeusesRepository $repoPointeuse,
    //     Request $request,
    //     $year,
    //     $month,
    //     $id,
    //     EntityManagerInterface $manager)
    // {

    //     $data = $repoPointeuse->findPaieByUser($manager,$year,$month,$id);
    //     return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    // }


    /**
     * @Route("/api/paie/getWeeksByUser/{year}/{month}/{id}", name="getWeeksByUser" ,methods={"GET"})
     */
    public function getWeeksByUser(
        PointeusesRepository $repoPointeuse,
        Request $request,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->getWeeksByUser($manager,$year,$month,$id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }


    /**
     * @Route("/api/paie/TotalHoursDone/{year}/{month}/{id}", name="TotalHoursDone" ,methods={"GET"})
     */
    public function TotalHoursDone(
        PointeusesRepository $repoPointeuse,
        Request $request,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->TotalHoursDone($manager,$year,$month,$id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }

    
    /**
     * @Route("/api/paie/TotalPlanningHours/{year}/{month}/{id}", name="TotalPlanningHours" ,methods={"GET"})
     */
    public function TotalPlanningHours(
        PointeusesRepository $repoPointeuse,
        Request $request,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->TotalPlanningHours($manager,$year,$month,$id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/api/paie/getOvertimes/{year}/{month}/{id}", name="getOvertimes" ,methods={"GET"})
     */
    public function getOvertimes(
        PointeusesRepository $repoPointeuse,
        Request $request,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->getOvertimes($manager,$year,$month,$id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/api/paie/getPaieDetail/{year}/{month}/{id}/{week}", name="getPaieDetail" ,methods={"GET"})
     */
    public function getPaieDetail(
        PointeusesRepository $repoPointeuse,
        Request $request,
        $year,
        $month,
        $id,
        $week,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->getPaieDetail($manager,$year,$month,$id,$week);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }

}
