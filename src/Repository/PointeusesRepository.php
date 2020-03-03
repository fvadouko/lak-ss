<?php

namespace App\Repository;

use App\Entity\Pointeuses;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function findAllPaies(
        EntityManagerInterface $manager
        )
    {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT (user.firstname || ' ' || user.lastname) AS name, user.hourlyrate AS hourlyrate, SUM(strftime('%H',p.departures) - strftime('%H',p.arrivals)) AS  volumehoraire, 
        (user.hourlyrate * SUM(strftime('%H',p.departures) - strftime('%H',p.arrivals))) as rawsalary 
        FROM pointeuses AS p 
        INNER JOIN user 
        on p.user_id = user.id 
        GROUP BY name";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return ($stmt->fetchAll());die('Erreur sql');
    }
}
