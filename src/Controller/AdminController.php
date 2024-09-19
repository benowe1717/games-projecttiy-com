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
use App\Entity\Character;
use App\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Player;
use App\Entity\User;
use App\Form\NewAttemptType;
use App\Form\NewCharacterType;
use App\Form\UpdateAttemptType;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    /**
     * HomeController constructor
     *
     * @param EntityManagerInterface $entityManager Entity Manager
     **/
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->getPlayers();
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
     * Get all primary jobs from the database
     *
     * @return array
     **/
    private function getPrimaryJobs(): array
    {
        $jobRepository = $this->entityManager
            ->getRepository(Job::class);
        return $jobRepository->getAvailablePrimaryJobs();
    }

    /**
     * Get all secondary jobs from the database
     *
     * @return array
     **/
    private function getSecondaryJobs(): array
    {
        $jobRepository = $this->entityManager
            ->getRepository(Job::class);
        return $jobRepository->getAvailableSecondaryJobs();
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
     * @return array
     **/
    public function getCharacters(Player $myPlayer): array
    {
        // return $myPlayer->getCharacters();
        $myCharacters = array();
        foreach ($myPlayer->getCharacters() as $character) {
            if (!$character->isCompleted()) {
                $myCharacters[] = $character;
            }
        }
        return $myCharacters;
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
            if (!$character->isCompleted()) {
                $myAttempts = $character->getAttempts();
                foreach ($myAttempts as $attempt) {
                    if ($attempt->isCurrent()) {
                        return $attempt;
                    }
                }
            }
        }
        return new Attempt();
    }

    /**
     * Get the user's player's character's most recent attempt
     *
     * @param Player $myPlayer The current logged in user's player
     *
     * @return Attempt
     **/
    public function getMostRecentAttempt(Player $myPlayer): Attempt
    {
        $attemptRepository = $this->entityManager
            ->getRepository(Attempt::class);
        $myCharacters = $myPlayer->getCharacters();
        foreach ($myCharacters as $character) {
            if (!$character->isCompleted()) {
                $attempt = $attemptRepository
                    ->getMostRecentAttemptbyCharacter($character);
                return $attempt;
            }
        }
        return new Attempt();
    }

    /**
     * / app_admin Route
     *
     * @param Request  $request  Form data
     * @param Autowire $photoDir Directory for character picture uploads
     *
     * @return Response
     **/
    #[Route('/admin', name: 'app_admin')]
    public function index(
        Request $request,
        #[Autowire('%character_photo_dir%')] string $photoDir
    ): Response {
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

            // Set challenge completed status
            $myCharacter = $attempt->getCharacterId();
            $myCharacter->setCompleted($updateAttemptForm['completed']->getData());
            $this->entityManager->persist($myCharacter);
            $this->entityManager->flush();

            // If you died, the attempt is no longer current
            if (!empty($attempt->getCauseOfDeath())) {
                $attempt->setCurrent(false);
            }

            // If the challenge was completed, the attempt is no longer current
            if ($myCharacter->isCompleted()) {
                $attempt->setCurrent(false);
                $attempt->setCauseOfDeath = 'None';
            }

            // Write update to database
            $this->entityManager->persist($attempt);
            $this->entityManager->flush();

            $this->addFlash('success', 'Attempt updated successfully!');

            return $this->redirectToRoute('app_admin');
        }
        // End Update Attempt tab

        // Start New Attempt tab
        $hasCauseOfDeath = 1;
        $mostRecentAttempt = $this->getMostRecentAttempt($myPlayer);
        $newAttempt = new Attempt();
        $newAttempt->setCharacterId($mostRecentAttempt->getCharacterId());
        $newAttempt->setAttemptNumber($mostRecentAttempt->getAttemptNumber() + 1);
        $newAttempt->setCurrent(true);
        $newAttempt->setAdventureLevel(1);
        $newAttempt->setTimePlayed(0);

        if ($currentAttempt->getId() === $mostRecentAttempt->getId()) {
            if (empty($currentAttempt->getCauseOfDeath())) {
                $hasCauseOfDeath = 0;
            }
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
        foreach ($errors as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        if ($newAttemptForm->isSubmitted() && $newAttemptForm->isValid()) {
            $newAttempt = $newAttemptForm->getData();

            // If causeOfDeath is set, update $currentAttempt
            if (!empty($newAttempt->getCauseOfDeath())) {
                $currentAttempt->setCauseOfDeath($newAttempt->getCauseOfDeath());
                $currentAttempt->setCurrent(false);

                // Update $currentAttempt
                $this->entityManager->persist($currentAttempt);
                $this->entityManager->flush();
            }

            // Update $newAttempt
            $this->entityManager->persist($newAttempt);
            $this->entityManager->flush();

            $this->addFlash('success', 'New Attempt started successfully!');

            return $this->redirectToRoute('app_admin');
        }
        // End New Attempt tab

        // Start New Character tab
        $newCharacter = new Character();
        $newCharacter->setPlayer($myPlayer);
        $newCharacterForm = $this->createForm(
            NewCharacterType::class,
            $newCharacter,
            [
                'primary_jobs' => $this->getPrimaryJobs(),
                'secondary_jobs' => $this->getSecondaryJobs(),
            ]
        );
        $newCharacterForm->handleRequest($request);
        $errors = $newCharacterForm->getErrors(true);
        foreach ($errors as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        if ($newCharacterForm->isSubmitted() && $newCharacterForm->isValid()) {
            $fileAttachment = $newCharacterForm->get('fileAttachment')->getData();
            $newCharacter = $newCharacterForm->getData();

            if ($fileAttachment) {
                $extension = $fileAttachment->guessExtension();
                if (!$extension) {
                    $extension = ".bad_upload";
                }

                $playerName = strtolower($myPlayer->getName());
                $characterName = strtolower($newCharacter->getName());
                $filename = "{$playerName}-{$characterName}.{$extension}";
                $newCharacter->setProfilePicture($filename);

                $fileAttachment->move($photoDir, $filename);
            }

            $this->entityManager->persist($newCharacter);
            $this->entityManager->flush();

            $this->addFlash('success', 'New Character started successfully!');

            return $this->redirectToRoute('app_admin');
        }
        // End New Character tab

        return $this->render(
            'admin/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->activePlayer,
                'update_attempt_form' => $updateAttemptForm,
                'completed_milestones' => $completedMilestones,
                'has_attempts' => $hasAttempts,
                'new_attempt_form' => $newAttemptForm,
                'has_cause_of_death' => $hasCauseOfDeath,
                'new_character_form' => $newCharacterForm,
            ]
        );
    }
}
