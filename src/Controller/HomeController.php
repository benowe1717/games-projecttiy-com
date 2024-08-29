<?php

/**
 * Symfony Controller for / Route
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
 * Symfony Controller for / Route
 *
 * @category  Controller
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class HomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public string $title = 'Home';
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
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render(
            'index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->activePlayer
            ]
        );
    }
}
