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

use App\Entity\Attempt;
use App\Entity\Job;
use App\Entity\Milestone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Player;
use App\Entity\User;
use App\Form\NewAttemptType;
use App\Form\UpdateAttemptType;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;

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
     * Get the Current User's Players
     *
     * @param User $currentUser The current logged in user
     *
     * @return ?Attempt
     **/
    public function getPlayer(User $currentUser): Player
    {
        return $currentUser->getPlayer();
    }

    /**
     * Get the Current Player's Characters
     *
     * @param Player $myPlayer The current logged in user's player
     *
     * @return Collection
     **/
    public function getCharacters(Player $myPlayer): Collection
    {
        return $myPlayer->getCharacters();
    }

    /**
     * Get the user's player's character's current attempt
     *
     * @param Player $myPlayer The current logged in user's player
     *
     * @return Attempt
     **/
    public function getCurrentAttempt(Player $myPlayer): Attempt
    {
        $myCharacters = $myPlayer->getCharacters();
        foreach ($myCharacters as $character) {
            $myAttempts = $character->getAttempts();
            foreach ($myAttempts as $attempt) {
                if ($attempt->isCurrent()) {
                    return $attempt;
                }
            }
        }
        return new Attempt();
    }

    /**
     * / app_admin Route
     *
     * @param Request $request Form data
     *
     * @return Response
     **/
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request): Response
    {
        // Data for all tabs and forms
        $currentUser = $this->getUser();
        $myPlayer = $this->getPlayer($currentUser);
        $myCharacters = $this->getCharacters($myPlayer);
        $currentAttempt = $this->getCurrentAttempt($myPlayer);
        $attempt = new Attempt();

        // Begin Update Attempt tab and form
        $completedMilestones = array();
        $hasAttempts = 1;

        if (empty($currentAttempt->isCurrent())) {
            $hasAttempts = 0;
        }

        $attempt = $currentAttempt;
        foreach ($currentAttempt->getMilestones() as $milestone) {
            $attempt->addMilestone($milestone);
            $completedMilestones[] = $milestone->getId();
        }
        $updateAttemptForm = $this->createForm(
            UpdateAttemptType::class,
            $attempt,
            [
                'characters' => $myCharacters,
            ]
        );
        $updateAttemptForm->handleRequest($request);
        $errors = $updateAttemptForm->getErrors(true);
        foreach ($errors as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        if ($updateAttemptForm->isSubmitted() && $updateAttemptForm->isValid()) {
            $attempt = $updateAttemptForm->getData();

            // If you died, the attempt is no longer current
            if (!empty($attempt->getCauseOfDeath())) {
                $attempt->setCurrent(false);
            }

            // Write update to database
            $this->entityManager->persist($attempt);
            $this->entityManager->flush();

            $this->addFlash('success', 'Attempt updated successfully!');

            return $this->redirectToRoute('app_admin');
        }
        // End Update Attempt tab

        // Start New Attempt tab
        $hasCauseOfDeath = 0;
        $newAttempt = new Attempt();
        $newAttempt->setCharacterId($currentAttempt->getCharacterId());

        if (!empty($currentAttempt->getCauseOfDeath())) {
            $hasCauseOfDeath = 1;
        }
        $newAttemptForm = $this->createForm(
            NewAttemptType::class,
            $newAttempt,
            [
                'characters' => $myCharacters,
            ]
        );
        $newAttemptForm->handleRequest($request);
        $errors = $newAttemptForm->getErrors(true);
        // End New Attempt tab

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
                'characters' => $characters,
                'roles' => $roles,
                'primary_jobs' => $primaryJobs,
                'secondary_jobs' => $secondaryJobs,
                'update_attempt_form' => $updateAttemptForm,
                'completed_milestones' => $completedMilestones,
                'has_attempts' => $hasAttempts,
                'new_attempt_form' => $newAttemptForm,
                'has_cause_of_death' => $hasCauseOfDeath,
            ]
        );
    }
}
