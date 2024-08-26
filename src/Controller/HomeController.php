<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private string $title = 'Games - Home';
    private array $players = array();
    private int $active_player = -1;

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $this->players[] = array('id' => 1, 'name' => 'specter2426');
        $this->players[] = array('id' => 2, 'name' => 'plantmafia');
        $this->players[] = array('id' => 3, 'name' => 'BearsFruit');

        return $this->render(
            'index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->active_player
            ]
        );
    }
}
