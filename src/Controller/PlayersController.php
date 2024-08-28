<?php

/**
 * Controller for /players route
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

use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller for /players route
 *
 * PHP version 8.3
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
    public EntityManagerInterface $entityManager;

    public array $players = array();
    public Player $player;
    public int $activePlayer = -1;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->getPlayers();

        $this->old_players[] = array('id' => 1, 'name' => 'specter2426', 'bio' => 'A cool short description of your character.', 'attempt_number' => 1, 'character_name' => 'ApakefHC', 'play_time' => 6, 'adventure_level' => 25);
        $this->old_players[] = array('id' => 2, 'name' => 'plantmafia', 'bio' => 'A cool short description of your character.', 'attempt_number' => 1, 'character_name' => 'Barrett Jr', 'play_time' => 50, 'adventure_level' => 25);
        $this->old_players[] = array('id' => 3, 'name' => 'BearsFruit', 'bio' => 'A cool short description of your character.', 'attempt_number' => 1, 'character_name' => 'Mr Silverado', 'play_time' => 2, 'adventure_level' => 10);
    }

    /**
     * Retrieve all players from database
     *
     * @return void
     **/
    public function getPlayers(): void
    {
        $playerRepository = $this->entityManager
            ->getRepository(Player::class);
        $this->players = $playerRepository->findAll();
    }

    /**
     * Retrieve player from database by ID
     *
     * @param string $playerId Player ID
     *
     * @return void
     **/
    public function getPlayer(string $playerId): void
    {
        $playerRepository = $this->entityManager->getRepository(Player::class);
        $this->player = $playerRepository->find($playerId);
    }

    /**
     * Render /players route
     *
     * @return Response
     **/
    #[Route('/players', name: 'app_players')]
    public function index(): Response
    {
        return $this->render(
            'players/index.html.twig',
            [
                'players' => $this->players,
                'active_player' => $this->activePlayer
            ]
        );
    }

    /**
     * Render /players/{id} route
     *
     * @param string $playerId Player ID
     *
     * @return Response
     **/
    #[Route('/players/{playerId}', name: 'app_player')]
    public function playerIndex(string $playerId): Response
    {
        $this->getPlayer($playerId);

        return $this->render(
            'players/player/index.html.twig',
            [
                'players' => $this->players,
                'active_player' => $playerId,
                'player' => $this->player,
            ]
        );
    }

    #[Route('/players/{id}/previous/{num}', name: 'app_player_previous')]
    public function previousIndex(string $id, string $num): Response
    {
        $currentPlayer = array();
        foreach ($this->players as $player) {
            if ($player['id'] == $id) {
                $currentPlayer = $player;
            }
        }

        $player_id = $id;
        $this->previous_attempts[] = array('id' => 1, 'number' => 1);

        return $this->render(
            'players/previous/index.html.twig',
            [
                'players' => $this->old_players,
                'previous_attempts' => $this->previous_attempts,
                'active_player' => $id,
                'player_id' => $id,
                'player' => $currentPlayer
            ]
        );
    }
}
