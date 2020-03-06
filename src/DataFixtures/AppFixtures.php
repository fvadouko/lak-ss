<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Event;
use App\Entity\Pointeuses;
use App\Entity\User;
use App\Repository\EventRepository;
use App\Repository\PointeusesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    protected $eventRepository;
    protected $pointeuseRepository;

    public function __construct(EventRepository $eventRepository, PointeusesRepository $pointeuseRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->pointeuseRepository = $pointeuseRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($p = 0; $p < 12; $p++) {
            $user = new User;
            $lastname = $faker->lastName();
            $user->setFirstname($faker->firstName())
                ->setLastname($lastname)
                ->setDesignation($this->getDesignation(mt_rand(0, 5)))
                ->setCreatedAt($faker->dateTimeBetween('-3 months'));

            $manager->persist($user);
            $manager->flush();
            $ml = mt_rand(40, 50);
            for ($c = 0; $c < $ml; $c++) {
                $event = new Event;
                $start = $faker->dateTimeBetween('-3 months', 'now');
                $nbHour =  strval(mt_rand(1, 5));
                $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +0 days +' . $nbHour . ' hours');
                $evt = $this->eventRepository->findOneBySomeField($start, $end, $user->getId());
                do {
                    $start = $faker->dateTimeBetween('-3 months', 'now');
                    $nbHour =  strval(mt_rand(1, 5));
                    $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +0 days +' . $nbHour . ' hours');
                    $evt = $this->eventRepository->findOneBySomeField($start, $end, $user->getId());
                } while (!is_null($evt));
                if (is_null($evt)) {
                    $time  = strtotime($start->format('Y-m-d H:i:s'));
                    $week   = date('W', $time);
                    $month = date('m', $time);
                    $year  = date('Y', $time);
                    $event->setTitle($faker->catchPhrase)
                        ->setLocation($faker->catchPhrase)
                        ->setRepeat($this->getRepeat(mt_rand(0, 4)))
                        ->setAllday(mt_rand(0, 1))
                        ->setTimezone(mt_rand(0, 1))
                        ->setStart($start)
                        ->setEndt($end)
                        ->setDescription($faker->paragraphs(1, true))
                        ->setUser($user)
                        ->setYear($year)
                        ->setMonth($this->getMonth(intval($month) - 1))
                        ->setWeek($week);

                    $manager->persist($event);
                }
                $pointeuse = new Pointeuses;
                $nbHour =  strval(mt_rand(1, 5));
                $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +0 days +' . $nbHour . ' hours');
                $point = $this->pointeuseRepository->findOneBySomeField($start, $end, $user->getId());
                do {

                    $nbHour =  strval(mt_rand(1, 5));
                    $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +0 days +' . $nbHour . ' hours');
                    $point = $this->eventRepository->findOneBySomeField($start, $end, $user->getId());
                } while (!is_null($point));
                if (is_null($point)) {
                    $time  = strtotime($start->format('Y-m-d H:i:s'));
                    $week   = date('W', $time);
                    $month = date('m', $time);
                    $year  = date('Y', $time);
                    $pointeuse->setArrivals($start)
                        ->setDepartures($end)
                        ->setOvertimes(mt_rand(1, 3))
                        ->setUser($user)
                        ->setYear($year)
                        ->setMonth($this->getMonth(intval($month) - 1))
                        ->setWeek($week);

                    $manager->persist($pointeuse);
                }
            }
        }

        $manager->flush();
    }

    private function getDesignation($i)
    {
        $arrayDesignation = ['Commercial', 'Comptable', 'DG', 'RH', 'Informaticien', 'Caissière'];
        return $arrayDesignation[$i];
    }

    private function getRepeat($i)
    {
        $arrayRepeat = ['Never', 'Daily', 'Weekly', 'Monthly', 'Yearly'];
        return $arrayRepeat[$i];
    }

    private function getMonth($i)
    {
        $arrayMonth = ['janvier', 'févier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'decembre'];
        return $arrayMonth[$i];
    }
}
