<?php

/**
 * Doctrine Repository for Milestone Entity
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

use App\Entity\Milestone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Doctrine Repository for Milestone Entity
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
 * @extends   ServiceEntityRepository<Milestone>
 */
class MilestoneRepository extends ServiceEntityRepository
{
    /**
     * MilestoneRepository constructor
     *
     * @param ManagerRegistry $registry ManagerRegistry
     **/
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Milestone::class);
    }

    /**
     * Get all Expedition Milestones
     *
     * @return Milestone[] Returns an Array of Milestone objects
     **/
    public function getExpeditionMilestones(): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.category = :val')
            ->setParameter('val', 'expedition')
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Milestone[] Returns an array of Milestone objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Milestone
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
