<?php

/**
 * Symfony Controller for /players Route
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

use App\Entity\Character;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Symfony Controller for /players Route
 *
 * @category  Controller
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class PlayersController extends AbstractController
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
     * Get player from database from ID
     *
     * @param int $id The Player's ID
     *
     * @return Player
     **/
    private function getPlayer(int $id): Player
    {
        $playerRepository = $this->entityManager
            ->getRepository(Player::class);
        return $playerRepository->find($id);
    }

    /**
     * Get all characters from database from Player object
     *
     * @param Player $player The Player Object
     *
     * @return array
     **/
    private function getPlayerCharacters(Player $player): array
    {
        $characterRepository = $this->entityManager
            ->getRepository(Character::class);
        return $characterRepository->findCharactersByPlayer($player);
    }

    /**
     * /players app_players Route
     *
     * @return Response
     **/
    #[Route('/players', name: 'app_players')]
    public function index(): Response
    {
        return $this->render(
            'players/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->activePlayer,
            ]
        );
    }

    /**
     * /players/{playerId} app_player Route
     *
     * @param string $playerId The Player's ID
     *
     * @return Response
     **/
    #[Route('/players/{playerId}', name: 'app_player')]
    public function playerIndex(string $playerId): Response
    {
        $player = $this->getPlayer($playerId);
        $characters = $this->getPlayerCharacters($player);

        return $this->render(
            'players/player/index.html.twig',
            [
                'title' => $player->getName(),
                'players' => $this->players,
                'active_player' => $player->getId(),
                'player' => $player,
                'characters' => $characters
            ]
        );
    }
}
