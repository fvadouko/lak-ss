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
        EntityManagerInterface $manager,
        $year,
        $month
    ) {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT (user.firstname || ' ' || user.lastname) AS name, user.hourlyrate AS hourlyrate, SUM(strftime('%H',p.departures) - strftime('%H',p.arrivals)) AS  volumehoraire, 
        (user.hourlyrate * SUM(strftime('%H',p.departures) - strftime('%H',p.arrivals))) as rawsalary 
        FROM pointeuses AS p 
        INNER JOIN user 
        on p.user_id = user.id and year = :year and month = :month
        GROUP BY name";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['year' => $year, 'month' => $month]);
        return ($stmt->fetchAll());
        die('Erreur sql');
    }

    public function findPaieByUser(
        EntityManagerInterface $manager,
        $year,
        $month,
        $id
    ) {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT (user.firstname || ' ' || user.lastname) AS name, 
        user.hourlyrate AS hourlyrate, 
        SUM(strftime('%H',p.departures) - strftime('%H',p.arrivals)) AS  volumehoraire, 
        user.id,
        p.week,
        (user.hourlyrate * SUM(strftime('%H',p.departures) - strftime('%H',p.arrivals))) as rawsalary 
        FROM pointeuses AS p 
        INNER JOIN user 
        on p.user_id = user.id and year = :year and month = :month
        INNER JOIN on user.id = event.user_id
        GROUP BY name 
        HAVING user.id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['year' => $year, 'month' => $month, 'id' => $id]);
        return ($stmt->fetchAll());
        die('Erreur sql');
    }


    // Recupere la liste des semaines du mois selectionné
    public function getWeeksByUser(
        EntityManagerInterface $manager,
        $year,
        $month,
        $id
    ) {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT DISTINCT week
        FROM event
        WHERE year = :year AND month = :month AND event.user_id = :id
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['year' => $year, 'month' => $month, 'id' => $id]);
        return ($stmt->fetchAll());
        die('Erreur sql');
    }


    // Recupere le total des heures prevues groupées par semaine
    public function TotalPlanningHours(
        EntityManagerInterface $manager,
        $year,
        $month,
        $id
    ) {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT SUM(strftime('%H',event.endt)  - strftime('%H',event.start)) AS TotalPlanningHours,
        week
        FROM event
        WHERE year = :year AND month = :month AND event.user_id = :id
        GROUP BY week
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['year' => $year, 'month' => $month, 'id' => $id]);
        return ($stmt->fetchAll());
        die('Erreur sql');
    }


    // Recupere le total des heures effectuees groupées par semaine
    public function TotalHoursDone(
        EntityManagerInterface $manager,
        $year,
        $month,
        $id
    ) {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT SUM(strftime('%H',pointeuses.departures)  - strftime('%H',pointeuses.arrivals)) AS TotalHoursDone,
        pointeuses.week FROM pointeuses WHERE year = :year AND month = :month AND pointeuses.user_id = :id GROUP BY week";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['year' => $year, 'month' => $month, 'id' => $id]);
        return ($stmt->fetchAll());
        die('Erreur sql');
    }

    public function findOneBySomeField($startTime, $endTime, $idUser): ?Pointeuses
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.arrivals = :val')
            ->setParameter('val', $startTime)
            ->andWhere('p.departures = :val')
            ->setParameter('val', $endTime)
            ->andWhere('p.user = :val')
            ->setParameter('val', $idUser)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
