<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppforusersFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($p = 0; $p < 10; $p++) {
            $user = new User;
            $lastname = $faker->lastName();
            $user->setFirstname($faker->firstName())
                ->setLastname($lastname)
                ->setDesignation($this->getDesignation(mt_rand(0, 5)))
                ->setPicture($this->getDesignation($faker->lastName() . 'png'))
                ->setCreatedAt($faker->dateTimeBetween('-6 months'));

            $manager->persist($user);

            for ($c = 0; $c < mt_rand(3, 5); $c++) {
                $event = new Event;
                $start = $faker->dateTimeBetween('now', 'now +15 days');
                $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +0 days');
                $event->setTitle($faker->catchPhrase)
                    ->setLocation($faker->catchPhrase)
                    ->setRepeat($this->getRepeat(mt_rand(0, 4)))
                    ->setAllday(mt_rand(0, 1))
                    ->setTimezone(mt_rand(0, 1))
                    ->setEmployees($lastname)
                    ->setStart($start)
                    ->setEndt($end)
                    ->setDescription($faker->paragraphs(1, true))
                    ->setUser($user);

                $manager->persist($event);
            }
        }

        $manager->flush();
    }

    private function getDesignation($i)
    {
        $arrayDesignation = ['Commercial', 'Comptable', 'DG', 'RH', 'Informaticien', 'Caissièree'];
        return $arrayDesignation[$i];
    }

    private function getRepeat($i)
    {
        $arrayRepeat = ['Never', 'Daily', 'Weekly', 'Monthly', 'Yearly'];
        return $arrayRepeat[$i];
    }
}
