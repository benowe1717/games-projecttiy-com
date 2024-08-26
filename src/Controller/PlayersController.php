<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlayersController extends AbstractController
{
    private string $title = 'Games - Players';
    private array $players = array();
    private int $active_player = -1;
    private array $previous_attempts = array();

    public function __construct()
    {
        $this->players[] = array('id' => 1, 'name' => 'specter2426', 'bio' => 'A cool short description of your character.', 'attempt_number' => 1, 'character_name' => 'ApakefHC', 'play_time' => 6);
        $this->players[] = array('id' => 2, 'name' => 'plantmafia', 'bio' => 'A cool short description of your character.', 'attempt_number' => 1, 'character_name' => 'Barrett Jr', 'play_time' => 50);
        $this->players[] = array('id' => 3, 'name' => 'BearsFruit', 'bio' => 'A cool short description of your character.', 'attempt_number' => 1, 'character_name' => 'Mr Silverado', 'play_time' => 2);
    }

    #[Route('/players', name: 'app_players')]
    public function index(): Response
    {
        return $this->render(
            'players/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->active_player
            ]
        );
    }

    #[Route('/players/{id}', name: 'app_player')]
    public function playerIndex(string $id): Response
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
            'players/player/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
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
        $player_id = $id;
        $this->previous_attempts[] = array('id' => 1, 'number' => 1);

        return $this->render(
            'players/previous/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'previous_attempts' => $this->previous_attempts,
                'active_player' => $id,
                'player_id' => $id
            ]
        );
    }
}
