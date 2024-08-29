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
     * / app_home Route
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

    // #[Route('/players/{playerId}', name: 'app_player')]
    // public function playerIndex(string $playerId): Response
    // {
    //     $this->getPlayer($playerId);
    //
    //     return $this->render(
    //         'players/player/index.html.twig',
    //         [
    //             'players' => $this->players,
    //             'active_player' => $playerId,
    //             'player' => $this->player,
    //         ]
    //     );
    // }
    //
    // #[Route('/players/{id}/previous/{num}', name: 'app_player_previous')]
    // public function previousIndex(string $id, string $num): Response
    // {
    //     $currentPlayer = array();
    //     foreach ($this->players as $player) {
    //         if ($player['id'] == $id) {
    //             $currentPlayer = $player;
    //         }
    //     }
    //
    //     $player_id = $id;
    //     $this->previous_attempts[] = array('id' => 1, 'number' => 1);
    //
    //     return $this->render(
    //         'players/previous/index.html.twig',
    //         [
    //             'players' => $this->old_players,
    //             'previous_attempts' => $this->previous_attempts,
    //             'active_player' => $id,
    //             'player_id' => $id,
    //             'player' => $currentPlayer
    //         ]
    //     );
    // }
}
