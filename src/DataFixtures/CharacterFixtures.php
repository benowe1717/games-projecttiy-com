<?php

/**
 * Doctrine Data Fixture for Character Entity
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

use App\Entity\Character;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Doctrine Data Fixture for Milestone Entity
 *
 * @category  DataFixture
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class CharacterFixtures extends Fixture implements DependentFixtureInterface
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

        $file = './data/characters.csv';

        $row = 1;
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }

                $name = $data[0];
                $bio = $data[1];
                $profilePicture = $data[2];
                $player = $data[3];
                $role = $data[4];
                $primaryJob = $data[5];
                $secondaryJob = $data[6];
                $completed = $data[7];
                $reference = $data[8];

                $character = new Character();
                $character->setName($name);
                $character->setBio($bio);
                $character->setProfilePicture($profilePicture);
                $character->setCompleted($completed);

                $ref = "player.{$player}";
                $playerRef = $this->getReference($ref);
                $character->setPlayer($playerRef);

                $ref = "role.{$role}";
                $roleRef = $this->getReference($ref);
                $character->setRole($roleRef);

                if (!empty($primaryJob)) {
                    $ref = "job.{$primaryJob}";
                    $primaryJobRef = $this->getReference($ref);
                    $character->setPrimaryJob($primaryJobRef);
                }

                if (!empty($secondaryJob)) {
                    $ref = "job.{$secondaryJob}";
                    $secondaryJobRef = $this->getReference($ref);
                    $character->setSecondaryJob($secondaryJobRef);
                }

                $manager->persist($character);
                $manager->flush();

                $ref = "character.{$reference}";
                $this->addReference($ref, $character);

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
            PlayerFixtures::class,
            RoleFixtures::class,
            JobFixtures::class
        ];
    }
}
