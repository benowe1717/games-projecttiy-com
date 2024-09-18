<?php

/**
 * Doctrine Repository for Job Entity
 *
 * PHP version 8.3
 *
 * @category  Repository
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   CVS: $Id:$
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Doctrine Repository for Job Entity
 *
 * PHP version 8.3
 *
 * @category  Repository
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 * @extends   ServiceEntityRepository<Job>
 */
class JobRepository extends ServiceEntityRepository
{
    /**
     * JobRepository constructor
     *
     * @param ManagerRegistry $registry ManagerRegistry
     **/
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    /**
     * Get All Primary Jobs
     *
     * @return Job[] Returns an array of Job objects
     **/
    public function getPrimaryJobs(): array
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.category = :val')
            ->setParameter('val', 'primary')
            ->orderBy('j.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get All Secondary Jobs
     *
     * @return Job[] Returns an array of Job objects
     **/
    public function getSecondaryJobs(): array
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.category = :val')
            ->setParameter('val', 'secondary')
            ->orderBy('j.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Job[] Returns an array of Job objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('j.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Job
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
