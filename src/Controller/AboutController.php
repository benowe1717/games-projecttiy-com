<?php

/**
 * Symfony Controller for /about Route
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

use App\Entity\Attempt;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Symfony Controller for /about Route
 *
 * @category  Controller
 * @package   Games-projecttiy-com
 * @author    Benjamin Owen <benjamin@projecttiy.com>
 * @copyright 2024 Benjamin Owen
 * @license   https://mit-license.org/ MIT
 * @version   Release: 0.0.1
 * @link      https://github.com/benowe1717/games-projecttiy-com
 **/
class AboutController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public string $title = 'Rules';
    public array $players = array();
    public int $activePlayer = -1;

    private array $allowed_rules = array();
    private array $not_allowed_rules = array();
    private array $but_what_if = array();
    private array $majorGoals = array();
    private array $minorGoals = array();

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
     * Get total number of attempts
     *
     * @return int
     **/
    private function getTotalAttempts(): int
    {
        $attemptRepository = $this->entityManager->getRepository(Attempt::class);
        $attempts = $attemptRepository->getTotalNumberOfAttempts();
        if (!$attempts) {
            return -1;
        }
        return $attempts[1];
    }

    /**
     * Get max adventure level
     *
     * @return int
     **/
    private function getMaxLevel(): int
    {
        $attemptRepository = $this->entityManager->getRepository(Attempt::class);
        $adventureLevel = $attemptRepository->getMaxAdventureLevel();
        if (!$adventureLevel) {
            return -1;
        }
        return $adventureLevel[1];
    }

    /**
     * Get total time played
     *
     * @return int
     **/
    private function getTimePlayed(): int
    {
        $attemptRepository = $this->entityManager->getRepository(Attempt::class);
        $timePlayed = $attemptRepository->getTotalTimePlayed();
        if (!$timePlayed) {
            return -1;
        }
        return $timePlayed[1];
    }

    /**
     * /about app_about Route
     *
     * @return Response
     **/
    #[Route('/about', name: 'app_about')]
    public function index(): Response
    {
        $this->allowed_rules[] = array(
            'name' =>
            'Use any Weapons and Armor that you loot at Uncommon tier or below'
        );
        $this->allowed_rules[] = array(
            'name' => 'Use any Weapons and Armor that has been crafted'
        );
        $this->allowed_rules[] = array(
            'name' => 'Trade with other Hardcore players in the Logicnow company'
        );
        $this->allowed_rules[] = array(
            'name' => 'Participate in any Quests, Events, or Expeditions'
        );
        $this->allowed_rules[] = array(
            'name' => 'Gather, harvest, mine, skin, etc.'
        );
        $this->allowed_rules[] = array(
            'name' => 'Refine any materials'
        );

        $this->not_allowed_rules[] = array(
            'name' => 'Use Weapons or Armor that you loot at Rare or above'
        );
        $this->not_allowed_rules[] = array(
            'name' => 'Buy or sell from the Trading post'
        );
        $msg = 'Trade with other non-hardcore players or hardcore players outside ';
        $msg .= 'of the Logicnow company';
        $this->not_allowed_rules[] = array(
            'name' => $msg
        );
        $this->not_allowed_rules[] = array(
            'name' =>
            'You cannot perform a Tradeskill outside of your designated Job'
        );
        $msg = 'On death, you cannot load up your character and save any items. ';
        $msg .= 'You <b><u>must</u></b> forfeit all items on you or in your ';
        $msg .= 'storage on death';
        $this->not_allowed_rules[] = array(
            'name' => $msg
        );
        $msg = 'That is a death. You lose the run and <b><u>must</u></b> ';
        $msg .= 'forfeit all of your ';
        $msg .= 'items on you and in your storage and delete the character.';
        $this->but_what_if[] = array(
            'name' => $msg
        );
        $this->but_what_if[] = array(
            'name' => $msg
        );
        $this->but_what_if[] = array(
            'name' => 'You are allowed to continue in this circumstance.'
        );
        $msg = "It's not good etiquette to leave teammates or other players ";
        $msg .= 'hanging. You can complete the Expedition, and then you <b><u>must';
        $msg .= '</u></b> delete your character and forfeit all items and loot.';
        $this->but_what_if[] = array(
            'name' => $msg
        );

        $this->majorGoals[] = array('name' => 'Complete the Main Story Quest');
        $this->majorGoals[] = array('name' => 'Achieve level 65');
        $this->majorGoals[] = array('name' => 'Complete All Expeditions');

        $this->minorGoals[] = array('name' => 'Max both weapon trees');
        $this->minorGoals[] = array('name' => 'Complete a full build');
        $this->minorGoals[] = array('name' => 'Max Job Tradeskills');

        return $this->render(
            'about/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->activePlayer,
                'allowed_rules' => $this->allowed_rules,
                'not_allowed_rules' => $this->not_allowed_rules,
                'but_what_if' => $this->but_what_if,
                'major_goals' => $this->majorGoals,
                'minor_goals' => $this->minorGoals,
                'play_time' => $this->getTimePlayed(),
                'adventure_level' => $this->getMaxLevel(),
                'attempts' => $this->getTotalAttempts()
            ]
        );
    }
}
