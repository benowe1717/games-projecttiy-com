<?php

/**
 * Doctrine Data Fixture for Attempt Entity
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

use App\Entity\Attempt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Doctrine Data Fixture for Attempt Entity
 *
 * @category  DataFixture
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class AttemptFixtures extends Fixture implements DependentFixtureInterface
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

        $attemptMilestones = $this->getAttemptMilestones();

        $file = './data/attempts.csv';

        $row = 1;
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }

                $attemptNumber = $data[0];
                $isCurrent = $data[1];
                $timePlayed = $data[2];
                $causeOfDeath = $data[3];
                $adventureLevel = $data[4];
                $character = $data[5];
                $reference = $data[6];

                $attempt = new Attempt();
                $attempt->setAttemptNumber($attemptNumber);
                $attempt->setCurrent($isCurrent);
                $attempt->setTimePlayed($timePlayed);
                $attempt->setCauseOfDeath($causeOfDeath);
                $attempt->setAdventureLevel($adventureLevel);

                $ref = "character.{$character}";
                $characterRef = $this->getReference($ref);
                $attempt->setCharacterId($characterRef);

                if (!empty($attemptMilestones[$reference])) {
                    foreach ($attemptMilestones[$reference] as $milestone) {
                        $ref = "milestone.{$milestone}";
                        $milestoneRef = $this->getReference($ref);
                        $attempt->addMilestone($milestoneRef);
                    }
                }

                $manager->persist($attempt);
                $manager->flush();

                $ref = "attempt.{$reference}";
                $this->addReference($ref, $attempt);

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
            CharacterFixtures::class,
            MilestoneFixtures::class,
        ];
    }

    /**
     * Pull in all milestones for each attempt
     *
     * @return array
     **/
    public function getAttemptMilestones(): array
    {
        $attemptMilestones = array();

        $file = './data/attempt_milestones.csv';

        $row = 1;
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }

                $attempt = $data[0];
                $milestone = $data[1];

                if (!array_key_exists($attempt, $attemptMilestones)) {
                    $attemptMilestones[$attempt] = array();
                }
                array_push($attemptMilestones[$attempt], $milestone);

                $row++;
            }
        }

        return $attemptMilestones;
    }
}
