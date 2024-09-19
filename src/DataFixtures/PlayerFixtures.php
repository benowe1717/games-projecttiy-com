<?php

/**
 * Doctrine Data Fixture for Player Entity
 *
 * PHP version 8.3
 *
 * @category  DataFixture
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   CVS: $Id:$
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/

namespace App\DataFixtures;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Doctrine Data Fixture for Player Entity
 *
 * @category  DataFixture
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class PlayerFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Load data into database
     *
     * @param ObjectManager $manager Persist data to database
     *
     * @return void
     **/
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // $manager->flush();

        $file = './data/players.csv';

        $row = 1;
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }

                $name = $data[0];
                $profilePicture = $data[1];
                $user = $data[2];
                $reference = $data[3];

                $player = new Player();
                $player->setName($name);
                $player->setProfilePicture($profilePicture);

                $ref = "user.{$user}";
                $userRef = $this->getReference($ref);
                $player->setUser($userRef);

                $manager->persist($player);
                $manager->flush();

                $ref = "player.{$reference}";
                $this->addReference($ref, $player);

                $row++;
            }
        }
    }

    /**
     * Pull in dependent DataFixtures
     *
     * @return List<class-string<FixtureInterface>>
     **/
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
