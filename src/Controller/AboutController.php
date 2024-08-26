<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutController extends AbstractController
{
    private string $title = 'Games - About';
    private array $players = array();
    private int $active_player = -1;
    private array $allowed_rules = array();
    private array $not_allowed_rules = array();
    private array $but_what_if = array();

    #[Route('/about', name: 'app_about')]
    public function index(): Response
    {
        $this->players[] = array('id' => 1, 'name' => 'specter2426');
        $this->players[] = array('id' => 2, 'name' => 'plantmafia');
        $this->players[] = array('id' => 3, 'name' => 'BearsFruit');

        $this->allowed_rules[] = array('name' => 'Use any Weapons and Armor that you loot at Uncommon tier or below');
        $this->allowed_rules[] = array('name' => 'Use any Weapons and Armor that has been crafted');
        $this->allowed_rules[] = array('name' => 'Trade with other Hardcore players in the Logicnow company');
        $this->allowed_rules[] = array('name' => 'Participate in any Quests, Events, or Expeditions');
        $this->allowed_rules[] = array('name' => 'Gather, harvest, mine, skin, etc.');
        $this->allowed_rules[] = array('name' => 'Refine any materials');

        $this->not_allowed_rules[] = array('name' => 'Use Weapons or Armor that you loot at Rare or above');
        $this->not_allowed_rules[] = array('name' => 'Buy or sell from the Trading post');
        $this->not_allowed_rules[] = array('name' => 'Trade with other non-hardcore players or hardcore players outside of the Logicnow company');
        $this->not_allowed_rules[] = array('name' => 'You cannot perform a Tradeskill outside of your designated Job');
        $this->not_allowed_rules[] = array('name' => 'On death, you cannot load up your character and save any items. You must forfeit all items on you or in your storage on death');

        $this->but_what_if[] = array('name' => 'That is a death. You lose the run and must forfeit all of your items on you and in your storage and delete the character.');
        $this->but_what_if[] = array('name' => 'That is a death. You lose the run and must forfeit all of your items on you and in your storage and delete the character.');
        $this->but_what_if[] = array('name' => 'You are allowed to continue in this circumstance.');
        $this->but_what_if[] = array('name' => 'It\'s not good etiquette to leave teammates or other players hanging. You can complete the Expedition, and then you must delete your character and forfeit all items and loot.');

        return $this->render(
            'about/index.html.twig',
            [
                'title' => $this->title,
                'players' => $this->players,
                'active_player' => $this->active_player,
                'allowed_rules' => $this->allowed_rules,
                'not_allowed_rules' => $this->not_allowed_rules,
                'but_what_if' => $this->but_what_if
            ]
        );
    }
}
