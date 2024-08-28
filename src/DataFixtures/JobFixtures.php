<?php

/**
 * Doctrine Data Fixture for Job Entity
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

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Doctrine Data Fixture for Job Entity
 *
 * @category  DataFixture
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class JobFixtures extends Fixture
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

        $file = './data/jobs.csv';

        $row = 1;
        if (($handle = fopen($file, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }

                $name = $data[0];
                $description = $data[1];
                $reference = $data[2];

                $job = new Job();
                $job->setName($name);
                $job->setDescription($description);

                $manager->persist($job);
                $manager->flush();

                $ref = "job.{$reference}";
                $this->addReference($ref, $job);

                $row++;
            }
        }
    }
}
