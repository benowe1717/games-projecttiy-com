<?php

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
 * @version   CVS: $Id:$
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/

namespace App\Repository;

use App\Entity\Character;
use App\Entity\Player;
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
 * @extends   ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository
{
    /**
     * CharacterRepository constructor
     *
     * @param ManagerRegistry $registry ManagerRegistry
     **/
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * Get All Characters by Player
     *
     * @param Player $player The Player Entity to search by
     *
     * @return Character[] Returns an array of Character objects
     **/
    public function findCharactersByPlayer(Player $player): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.player = :val')
            ->setParameter('val', $player)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Character[] Returns an array of Character objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Character
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
