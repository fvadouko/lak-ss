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
     * @Route("/api/paie/findAll/{year}/{month}", name="findAllPaie" ,methods={"GET"})
     */
    public function findAll(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        EntityManagerInterface $manager
    ) {

        $data = $repoPointeuse->findAllPaies($manager, $year, $month);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }


    /**
     * @Route("/api/paie/getWeeksByUser/{year}/{month}/{id}", name="getWeeksByUser" ,methods={"GET"})
     */
    public function getWeeksByUser(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager
    ) {

        $data = $repoPointeuse->getWeeksByUser($manager, $year, $month, $id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }


    /**
     * @Route("/api/paie/TotalHoursDone/{year}/{month}/{id}", name="TotalHoursDone" ,methods={"GET"})
     */
    public function TotalHoursDone(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager
    ) {

        $data = $repoPointeuse->TotalHoursDone($manager, $year, $month, $id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }


    /**
     * @Route("/api/paie/TotalHoursDones/{year}/{month}/{id}", name="TotalHoursDones" ,methods={"GET"})
     */
    public function TotalHoursDones(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->TotalHoursDones($manager,$year,$month,$id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }
    

    /**
     * @Route("/api/paie/TotalPlanningHours/{year}/{month}/{id}", name="TotalPlanningHours" ,methods={"GET"})
     */
    public function TotalPlanningHours(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager
    ) {

        $data = $repoPointeuse->TotalPlanningHours($manager, $year, $month, $id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }


    /**
     * @Route("/api/paie/getOvertimes/{year}/{month}/{id}", name="getOvertimes" ,methods={"GET"})
     */
    public function getOvertimes(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->getOvertimes($manager,$year,$month,$id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }


    /**
     * @Route("/api/paie/weeksPlanned/{year}/{month}/{id}", name="weeksPlanned" ,methods={"GET"})
     */
    public function weeksPlanned(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->weeksPlanned($manager,$year,$month,$id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }


    /**
     * @Route("/api/paie/getEventsByUser/{year}/{month}/{id}", name="getEventsByUser" ,methods={"GET"})
     */
    public function getEventsByUser(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->getEventsByUser($manager,$year,$month,$id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }


    /**
     * @Route("/api/paie/getPointeusesByUser/{year}/{month}/{id}", name="getPointeusesByUser" ,methods={"GET"})
     */
    public function getPointeusesByUser(
        PointeusesRepository $repoPointeuse,
        $year,
        $month,
        $id,
        EntityManagerInterface $manager)
    {

        $data = $repoPointeuse->getPointeusesByUser($manager,$year,$month,$id);
        return new Response(json_encode($data), 200, array('Content-Type' => 'application/json'));
    }
}
