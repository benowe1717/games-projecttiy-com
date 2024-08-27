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
    private EntityManagerInterface $_entityManager;

    private array $_players = array();
    private int $active_player = -1;
    private array $previous_attempts = array();

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->_entityManager = $entityManager;

        $this->old_players[] = array('id' => 1, 'name' => 'specter2426', 'bio' => 'A cool short description of your character.', 'attempt_number' => 1, 'character_name' => 'ApakefHC', 'play_time' => 6, 'adventure_level' => 25);
        $this->old_players[] = array('id' => 2, 'name' => 'plantmafia', 'bio' => 'A cool short description of your character.', 'attempt_number' => 1, 'character_name' => 'Barrett Jr', 'play_time' => 50, 'adventure_level' => 25);
        $this->old_players[] = array('id' => 3, 'name' => 'BearsFruit', 'bio' => 'A cool short description of your character.', 'attempt_number' => 1, 'character_name' => 'Mr Silverado', 'play_time' => 2, 'adventure_level' => 10);
    }

    /**
     * Retrieve all players from database
     *
     * @return void
     **/
    private function _getPlayers(): void
    {
        $playerRepository = $this->_entityManager
            ->getRepository(Player::class);
        $this->_players = $playerRepository->findAll();
    }

    /**
     * Render /players route
     *
     * @return Response
     **/
    #[Route('/players', name: 'app_players')]
    public function index(): Response
    {
        $this->_getPlayers();

        return $this->render(
            'players/index.html.twig',
            [
                'players' => $this->_players,
                'active_player' => $this->active_player
            ]
        );
    }

    #[Route('/players/{id}', name: 'app_player')]
    public function playerIndex(string $id): Response
    {
        $currentPlayer = array();
        foreach ($this->_players as $player) {
            if ($player['id'] == $id) {
                $currentPlayer = $player;
            }
        }

        $player_id = $id;
        $this->previous_attempts[] = array('id' => 1, 'number' => 1);

        return $this->render(
            'players/player/index.html.twig',
            [
                'players' => $this->old_players,
                'previous_attempts' => $this->previous_attempts,
                'active_player' => $id,
                'player_id' => $id,
                'player' => $currentPlayer
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
