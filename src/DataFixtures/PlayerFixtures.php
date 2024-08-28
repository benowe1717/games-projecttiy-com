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

        $playerMilestones = $this->getPlayerMilestones();

        $file = './data/players.csv';

        $row = 1;
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }

                $name = $data[0];
                $bio = $data[1];
                $profile = $data[2];
                $attemptNumber = $data[3];
                $characterName = $data[4];
                $playTime = $data[5];

                $player = new Player();
                $player->setName($name);
                $player->setBio($bio);
                $player->setProfile($profile);
                $player->setAttemptNumber($attemptNumber);
                $player->setCharacterName($characterName);
                $player->setPlayTime($playTime);
                if (!empty($playerMilestones[$name])) {
                    foreach ($playerMilestones[$name] as $milestone) {
                        $ref = "milestone.{$milestone}";
                        $milestoneRef = $this->getReference($ref);
                        $player->addMilestone($milestoneRef);
                    }
                }

                $manager->persist($player);
                $manager->flush();

                $ref = "player.{$name}";
                $this->addReference($ref, $player);

                $row++;
            }
        }
    }

    /**
     * Get dependent DataFixtures
     *
     * @return array
     **/
    public function getDependencies(): array
    {
        return [
            MilestoneFixtures::class,
        ];
    }

    /**
     * Pull in all milestones associated for each created player
     *
     * @return array
     **/
    public function getPlayerMilestones(): array
    {
        $playerMilestones = array();

        $file = './data/player_milestones.csv';

        $row = 1;
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }

                $playerName = $data[0];
                $milestoneName = $data[1];

                if (!array_key_exists($playerName, $playerMilestones)) {
                    $playerMilestones[$playerName] = array();
                }
                array_push($playerMilestones[$playerName], $milestoneName);

                $row++;
            }
        }

        return $playerMilestones;
    }
}
