<?php

/**
 * Doctrine Repository for Attempt Entity
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

use App\Entity\Attempt;
use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Doctrine Repository for Character Entity
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
 * @extends   ServiceEntityRepository<Attempt>
 */
class AttemptRepository extends ServiceEntityRepository
{
    /**
     * AttemptRepository constructor
     *
     * @param ManagerRegistry $registry ManagerRegistry
     **/
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attempt::class);
    }

    /**
     * Find an Attempt by Attempt ID and Character
     *
     * @param int       $attemptId The Attempt's ID
     * @param Character $character The Character object
     *
     * @return ?Attempt
     **/
    public function findPreviousAttemptByAttemptId(
        int $attemptId,
        Character $character
    ): ?Attempt {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->andWhere('a.characterId = :character')
            ->setParameter('id', $attemptId)
            ->setParameter('character', $character)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the total number of Attempts
     *
     * @return array
     **/
    public function getTotalNumberOfAttempts(): array
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the max adventure level of all attempts
     *
     * @return array
     **/
    public function getMaxAdventureLevel(): array
    {
        return $this->createQueryBuilder('a')
            ->select('MAX(a.adventureLevel)')
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the total amount of time played of all attempts
     *
     * @return array
     **/
    public function getTotalTimePlayed(): array
    {
        return $this->createQueryBuilder('a')
            ->select('SUM(a.timePlayed)')
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the most recent attempt for a character
     *
     * @param Character $characterId The character's id
     *
     * @return Attempt
     **/
    public function getMostRecentAttemptbyCharacter(Character $characterId): Attempt
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.characterId = :val')
            ->setParameter('val', $characterId)
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Attempt[] Returns an array of Attempt objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Attempt
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
