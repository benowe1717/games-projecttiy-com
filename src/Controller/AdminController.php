<?php

/**
 * Symfony Controller for /admin Route
 *
 * PHP version 8.3
 *
 * @category  Controller
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   CVS: $Id:$
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Milestone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Player;

/**
 * Symfony Controller for /admin Route
 *
 * @category  Controller
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class AdminController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public string $title = 'Admin';
    public array $players = array();
    public int $activePlayer = -1;
    public array $milestones = array();
    public array $jobs = array();

    /**
     * HomeController constructor
     *
     * @param EntityManagerInterface $entityManager Entity Manager
     **/
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->getPlayers();
        $this->getMilestones();
        $this->getJobs();
    }

    /**
     * Get all players from the database
     *
     * @return void
     **/
    private function getPlayers(): void
    {
        $playerRepository = $this->entityManager
            ->getRepository(Player::class);
        $this->players = $playerRepository->findAll();
    }

    /**
     * Get all milestones from the database
     *
     * @return void
     **/
    private function getMilestones(): void
    {
        $milestoneRepository = $this->entityManager
            ->getRepository(Milestone::class);
        $this->milestones = $milestoneRepository->findAll();
    }

    /**
     * Get all jobs from the database
     *
     * @return void
     **/
    private function getJobs(): void
    {
        $jobRepository = $this->entityManager
            ->getRepository(Job::class);
        $this->jobs = $jobRepository->findAll();
    }

    /**
     * / app_admin Route
     *
     * @return Response
     **/
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $currentAttempt = array('causeOfDeath' => 0);
        $characters[] = array('id' => 1, 'name' => 'characterName');
        $roles[] = array('id' => 1, 'name' => 'Damage');
        $roles[] = array('id' => 2, 'name' => 'Tank');
        $roles[] = array('id' => 3, 'name' => 'Healer');

        $primaryJobs = array();
        $primaryJobsList = array('Armorer', 'Weaponsmith', 'Engineer');

        $secondaryJobs = array();
        $secondaryJobsList = array('Provisioner', 'Alchemist', 'Artisan');

        foreach ($this->jobs as $job) {
            if (in_array($job->getName(), $primaryJobsList)) {
                $primaryJobs[] = $job;
            }

            if (in_array($job->getName(), $secondaryJobsList)) {
                $secondaryJobs[] = $job;
            }
        }

        return $this->render(
            'admin/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->activePlayer,
                'milestones' => $this->milestones,
                'current_attempt' => $currentAttempt,
                'characters' => $characters,
                'roles' => $roles,
                'primary_jobs' => $primaryJobs,
                'secondary_jobs' => $secondaryJobs
            ]
        );
    }
}
