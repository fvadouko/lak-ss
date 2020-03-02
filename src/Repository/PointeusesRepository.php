<?php

namespace App\Repository;

use App\Entity\Pointeuses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Pointeuses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pointeuses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pointeuses[]    findAll()
 * @method Pointeuses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointeusesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pointeuses::class);
    }

    // /**
    //  * @return Pointeuses[] Returns an array of Pointeuses objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pointeuses
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // public function paieForAll(EntityManagerInterface $manager)
    // {
    //     $conn = $manager->getConnection();
    //     $sql = '
    //         SELECT SUM(p.departures - p.arrivals) as volumeHoraire, u.hourlyRate as tauxHoraire, cat.name
    //         FROM fortune_cookie fc
    //         INNER JOIN category cat ON cat.id = fc.category_id
    //         WHERE fc.category_id = :category
    //         ';
    // $stmt = $conn->prepare($sql);
    // $stmt->execute(array('category' => $category->getId()));
    // return ($stmt->fetchAll());die;
    // }
}
