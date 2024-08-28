<?php

namespace App\Entity;

use App\Repository\AttemptRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttemptRepository::class)]
class Attempt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $attemptNumber = null;

    #[ORM\Column]
    private ?bool $isCurrent = null;

    #[ORM\Column]
    private ?int $timePlayed = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $causeOfDeath = null;

    #[ORM\Column]
    private ?int $adventureLevel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getAttemptNumber(): ?int
    {
        return $this->attemptNumber;
    }

    public function setAttemptNumber(int $attemptNumber): static
    {
        $this->attemptNumber = $attemptNumber;

        return $this;
    }

    public function isCurrent(): ?bool
    {
        return $this->isCurrent;
    }

    public function setCurrent(bool $isCurrent): static
    {
        $this->isCurrent = $isCurrent;

        return $this;
    }

    public function getTimePlayed(): ?int
    {
        return $this->timePlayed;
    }

    public function setTimePlayed(int $timePlayed): static
    {
        $this->timePlayed = $timePlayed;

        return $this;
    }

    public function getCauseOfDeath(): ?string
    {
        return $this->causeOfDeath;
    }

    public function setCauseOfDeath(?string $causeOfDeath): static
    {
        $this->causeOfDeath = $causeOfDeath;

        return $this;
    }

    public function getAdventureLevel(): ?int
    {
        return $this->adventureLevel;
    }

    public function setAdventureLevel(int $adventureLevel): static
    {
        $this->adventureLevel = $adventureLevel;

        return $this;
    }
}
