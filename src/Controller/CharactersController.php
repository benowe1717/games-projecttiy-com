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

    // #[Route('/characters', name: 'app_characters')]
    // public function index(): Response
    // {
    //     return $this->render('characters/index.html.twig', [
    //         'controller_name' => 'CharactersController',
    //     ]);
    // }

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

        return $this->render(
            'players/characters/index.html.twig',
            [
                'title' => $character->getName(),
                'players' => $this->players,
                'active_player' => $character->getPlayer()->getId(),
                'character' => $character
            ]
        );
    }
}
