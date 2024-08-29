<?php

/**
 * Symfony Controller for /characters Route
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
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Symfony Controller for /characters Route
 *
 * @category  Controller
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class CharactersController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public string $title = 'Players';
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
     * Get character from database from ID
     *
     * @param int $id The Character's ID
     *
     * @return Character
     **/
    private function getCharacter(int $id): Character
    {
        $characterRepository = $this->entityManager
            ->getRepository(Character::class);
        return $characterRepository->find($id);
    }

    /**
     * Get previous attempt by attempt id
     *
     * @param int       $attemptId The Attempt's ID
     * @param Character $character The Character object
     *
     * @return ?Attempt
     **/
    private function getAttempt(int $attemptId, Character $character): ?Attempt
    {
        $attemptRepository = $this->entityManager
            ->getRepository(Attempt::class);
        return $attemptRepository
            ->findPreviousAttemptByAttemptId($attemptId, $character);
    }

    /**
     * /characters/{characterId} app_character Route
     *
     * @param string $characterId The Character's ID
     *
     * @return Response
     **/
    #[Route('/characters/{characterId}', name: 'app_character')]
    public function index(string $characterId): Response
    {
        $character = $this->getCharacter($characterId);

        $currentAttempt = '';
        $attempts = $character->getAttempts();
        foreach ($attempts as $attempt) {
            if ($attempt->isCurrent()) {
                $currentAttempt = $attempt;
            }
        }

        $currentMilestones = array();
        $milestones = $currentAttempt->getMilestones();
        foreach ($milestones as $milestone) {
            $currentMilestones[] = array(
                'name' => $milestone->getName(),
                'description' => $milestone->getDescription()
            );
        }

        return $this->render(
            'players/characters/index.html.twig',
            [
                'title' => $character->getName(),
                'players' => $this->players,
                'active_player' => $character->getPlayer()->getId(),
                'character' => $character,
                'current_attempt' => $currentAttempt,
                'milestones' => $currentMilestones
            ]
        );
    }

    /**
     * /characters/{characterId}/previous/{attemptId} app_previous Route
     *
     * @param string $characterId The Character's ID
     * @param string $attemptId   The Previous Attempt ID
     *
     * @return Response
     **/
    #[Route('/characters/{characterId}/previous/{attemptId}', name: 'app_previous')]
    public function previousIndex(string $characterId, string $attemptId): Response
    {
        $character = $this->getCharacter($characterId);
        $attempt = $this->getAttempt($attemptId, $character);

        if (empty($attempt)) {
            throw $this->createNotFoundException(
                'This previous attempt does not belong to this character!'
            );
        }

        $previousMilestones = array();
        $milestones = $attempt->getMilestones();
        foreach ($milestones as $milestone) {
            $previousMilestones[] = array(
                'name' => $milestone->getName(),
                'description' => $milestone->getDescription()
            );
        }

        return $this->render(
            'players/characters/previous/index.html.twig',
            [
                'title' => $character->getName(),
                'players' => $this->players,
                'active_player' => $character->getPlayer()->getId(),
                'character' => $character,
                'attempt' => $attempt,
                'milestones' => $previousMilestones
            ]
        );
    }
}
