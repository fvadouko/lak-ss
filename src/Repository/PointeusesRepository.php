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

    // public function findPaieByUser(
    //     EntityManagerInterface $manager,
    //     $year,
    //     $month,
    //     $id
    // )

    // {
    //     $conn = $manager->getConnection();

    //     //Format de requete pour Sqlite
    //     $sql = "
    //     SELECT 
    //         (user.firstname || ' ' || user.lastname) AS name, 
    //         user.hourlyrate AS hourlyrate, 
    //         SUM(strftime('%H',p.departures) - strftime('%H',p.arrivals)) AS  volumehoraire, 
    //         user.id AS user,
    //         p.week AS week,
    //         p.year AS year,
    //         p.month as month
    //         (user.hourlyrate * SUM(strftime('%H',p.departures) - strftime('%H',p.arrivals))) as rawsalary 
    //     FROM pointeuses AS p 
    //     INNER JOIN user 
    //         on p.user_id = user.id and year = :year and 
    //         month = :month
    //     INNER JOIN on user.id = event.user_id
    //     GROUP BY name 
    //     HAVING user.id = :id";
        
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute(['year'=>$year,'month'=>$month,'id'=>$id]);
    //     return ($stmt->fetchAll());die('Erreur sql');
    // }


    public function findAllPaies(
        EntityManagerInterface $manager,
        $year,
        $month
    )

    {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite  SUM(strftime('%H',p.departures) - strftime('%H',p.arrivals))
        $sql = "
        SELECT 
            (user.firstname || ' ' || user.lastname) AS name, 
            user.hourlyrate AS hourlyrate, 
            SUM(strftime('%H', p.departures) - strftime('%H', p.arrivals)) AS volumehoraire, 
            (user.hourlyrate * SUM(strftime('%s', p.departures)/3600 - strftime('%s', p.arrivals)/3600)) as rawsalary,
            user.id AS user,
            p.week AS week,
            p.year AS year,
            p.month as month 
        FROM pointeuses AS p 
        INNER JOIN user 
            on p.user_id = user.id and p.year = :year and p.month = :month
        GROUP BY name";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['year'=>$year,'month'=>$month]);
        return ($stmt->fetchAll());die('Erreur sql');
    }

    /////////////////////////////////////////////////////////////////////////
    // Recupere la liste des semaines du mois selectionné
    public function getWeeksByUser(
        EntityManagerInterface $manager,
        $year,
        $month,
        $id
    )

    {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT 
            DISTINCT week,
            year,
            month
        FROM event
        WHERE 
            year = :year AND month = :month AND 
            event.user_id = :id
        ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(['year'=>$year,'month'=>$month,'id'=>$id]);
        return ($stmt->fetchAll());die('Erreur sql');
    }

    /////////////////////////////////////////////////////////////////////////
    // Recupere le total des heures prevues groupées par semaine
    public function TotalPlanningHours(
        EntityManagerInterface $manager,
        $year,
        $month,
        $id
    )

    {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT 
            SUM(strftime('%s',event.endt)/3600  - strftime('%s',event.start)/3600) AS TotalPlanningHours,
            week
        FROM event
        WHERE 
            year = :year AND month = :month AND 
            event.user_id = :id
        GROUP BY week
        ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(['year'=>$year,'month'=>$month,'id'=>$id]);
        return ($stmt->fetchAll());die('Erreur sql');
    }

    /////////////////////////////////////////////////////////////////////////
    // Recupere le total des heures effectuees groupées par semaine
    public function TotalHoursDone(
        EntityManagerInterface $manager,
        $year,
        $month,
        $id
    )

    {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT 
            SUM(strftime('%H',pointeuses.departures) - strftime('%H',pointeuses.arrivals)) AS TotalHoursDone,
            pointeuses.week,
            pointeuses.user_id
        FROM 
            pointeuses
        WHERE 
            pointeuses.year = :year AND 
            pointeuses.month = :month AND 
            pointeuses.user_id = :id
        GROUP BY pointeuses.week";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(['year'=>$year,'month'=>$month,'id'=>$id]);
        return ($stmt->fetchAll());die('Erreur sql');
    }

/////////////////////////////////////////////////////////////////////////
    // TEST
    public function TotalHoursDones(
        EntityManagerInterface $manager,
        $year,
        $month,
        $id
    )

    {
        $conn = $manager->getConnection();

        //Format de requete pour Sqlite
        $sql = "
        SELECT 
            SUM(strftime('%s',pointeuses.departures) - strftime('%s',pointeuses.arrivals))/3600 AS total
        FROM 
            pointeuses
        WHERE 
            pointeuses.year = :year AND 
            pointeuses.month = :month AND 
            pointeuses.user_id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute(['year'=>$year,'month'=>$month,'id'=>$id]);
        return ($stmt->fetchAll());die('Erreur sql');
    }


        /////////////////////////////////////////////////////////////////////////
        // Recupere la liste des heures sup
        public function getOvertimes(
            EntityManagerInterface $manager,
            $year,
            $month,
            $id
        )
    
        {
            $conn = $manager->getConnection();
    
            //Format de requete pour Sqlite
            $sql = "
            SELECT 
                SUM(pointeuses.overtimes) AS overtimes,
                pointeuses.week AS week
            FROM pointeuses
            WHERE 
                pointeuses.year = :year AND 
                pointeuses.month = :month AND 
                pointeuses.user_id = :id
            GROUP BY week
            ";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute(['year'=>$year,'month'=>$month,'id'=>$id]);
            return ($stmt->fetchAll());die('Erreur sql');
        }


        /////////////////////////////////////////////////////////////////////////
        // Renvoie la liste des events (le numero du jour, la semaine,...) par User 
        //en fonction de year, month id du User
        public function getEventsByUser(
            EntityManagerInterface $manager,
            $year,
            $month,
            $id
        )
    
        {
            $conn = $manager->getConnection();
    
            //Format de requete pour Sqlite strftime('%w',event.start) as jour
            $sql = "
            SELECT 
                event.week as week,
                strftime('%w',event.start) as jour,
                strftime('%d',event.start) as lejour,
                strftime('%H',event.start) as hdbt,
                event.title,
                event.id AS eventID,
                TIME(event.start) as debutPrevu,
                TIME(event.endt) as finPrevu,
                event.start as heureArrivee,
                event.endt as heureDepart,
                event.user_id as user
            FROM event
            WHERE
                event.year = :year AND
                event.month = :month AND
                event.user_id = :id
                ";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute(['year'=>$year,'month'=>$month,'id'=>$id]);
            return ($stmt->fetchAll());die('Erreur sql');
        }

        /////////////////////////////////////////////////////////////////////////
        // Renvoie la liste des pointeuses () par User en fonction de year, month id du User
        public function getPointeusesByUser(
            EntityManagerInterface $manager,
            $year,
            $month,
            $id
        )
    
        {
            $conn = $manager->getConnection();
    
            //Format de requete pour Sqlite strftime('%w',event.start) as jour
            $sql = "
            SELECT 
                pointeuses.week as week,
                strftime('%w',pointeuses.arrivals) as jour,
                strftime('%H:%M:%S',pointeuses.arrivals) as lheure,
                strftime('%H',pointeuses.arrivals) as hdbt,
                pointeuses.arrivals as heureArrivee,
                pointeuses.departures as heureDepart,
                pointeuses.id AS pointeusesID,
                TIME(pointeuses.arrivals) as debutReel,
                TIME(pointeuses.departures) as finReel,
                pointeuses.user_id as user
            FROM pointeuses
            WHERE
                pointeuses.year = :year AND
                pointeuses.month = :month AND
                pointeuses.user_id = :id
                ";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute(['year'=>$year,'month'=>$month,'id'=>$id]);
            return ($stmt->fetchAll());die('Erreur sql');
        }


    

}
