<?php

/**
 * Symfony Controller for /contact Route
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
 * Symfony Controller for /contact Route
 *
 * @category  Controller
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class ContactController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public string $title = 'Contact';
    public array $players = array();
    public int $activePlayer = -1;
    public string $email;
    public string $github;
    public string $mastodonUrl;
    public string $mastodonUser;

    /**
     * HomeController constructor
     *
     * @param EntityManagerInterface $entityManager Entity Manager
     **/
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->getPlayers();
        $this->email = 'benjamin@projecttiy.com';
        $this->github = 'https://github.com/benowe1717/games-projecttiy-com/issues';
        $this->mastodonUrl = 'https://mas.to/@specter2426';
        $this->mastodonUser = '@specter2426';
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
     * /contact app_contact Route
     *
     * @return Response
     **/
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render(
            'contact/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->activePlayer,
                'email' => $this->email,
                'github' => $this->github,
                'mastodon_url' => $this->mastodonUrl,
                'mastodon_user' => $this->mastodonUser
            ]
        );
    }
}
