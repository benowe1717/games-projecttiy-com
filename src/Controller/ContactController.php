<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    private string $title = 'Games - Contact';
    private array $players = array();
    private int $active_player = -1;

    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        $this->players[] = array('id' => 1, 'name' => 'specter2426');
        $this->players[] = array('id' => 2, 'name' => 'plantmafia');
        $this->players[] = array('id' => 3, 'name' => 'BearsFruit');

        return $this->render(
            'contact/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->active_player
            ]
        );
    }
}
