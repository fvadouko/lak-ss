<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // for ($p = 0; $p < 50; $p++) {
        //     $post = new Post;
        //     $post->setTitle($faker->catchPhrase)
        //         ->setContent($faker->paragraphs(5, true))
        //         ->setCreatedAt($faker->dateTimeBetween('-6 months'));

        //     $manager->persist($post);

        //     for ($c = 0; $c < mt_rand(3, 5); $c++) {
        //         $comment = new Comment;
        //         $comment->setContent($faker->paragraphs(mt_rand(1, 3), true))
        //             ->setUsername($faker->userName)
        //             ->setPost($post);

        //         $manager->persist($comment);
        //     }
        // }

        $manager->flush();

        for ($p = 0; $p < 10; $p++) {
            $user = new User;
            $lastname = $faker->lastName();
            $user->setFirstname($faker->firstName())
                ->setLastname($lastname)
                ->setDesignation($this->getDesignation(mt_rand(0, 5)))
                ->setPicture($lastname . '.png')
                ->setCreatedAt($faker->dateTimeBetween('-3 months'));

            $manager->persist($user);

            for ($c = 0; $c < mt_rand(3, 5); $c++) {
                $event = new Event;
                $start = $faker->dateTimeBetween('now', 'now +15 days');
                $end = $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s') . ' +0 days +2 hours');
                $event->setTitle($faker->catchPhrase)
                    ->setLocation($faker->catchPhrase)
                    ->setRepeat($this->getRepeat(mt_rand(0, 4)))
                    ->setAllday(mt_rand(0, 1))
                    ->setTimezone(mt_rand(0, 1))
                    ->setStart($start)
                    ->setEndt($end)
                    ->setDescription($faker->paragraphs(1, true))
                    ->setUser($user);

                $manager->persist($event);
            }
        }

        $manager->flush();

        for ($p = 0; $p < 10; $p++) {
            $user = new User;
            $lastname = $faker->lastName();
            $user->setFirstname($faker->firstName())
                ->setLastname($lastname)
                ->setDesignation($this->getDesignation(mt_rand(0, 5)))
                ->setPicture($lastname . '.png')
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
