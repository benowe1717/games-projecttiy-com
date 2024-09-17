<?php

namespace App\Entity;

use App\Repository\AttemptRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'The Cause of Death must be longer than {{ limit }} characters!',
        maxMessage: 'The Cause of Death must be shorter than {{ limit }} characters!'
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $causeOfDeath = null;

    #[ORM\Column]
    private ?int $adventureLevel = null;

    #[ORM\ManyToOne(inversedBy: 'attempts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $characterId = null;

    /**
     * @var Collection<int, Milestone>
     */
    #[ORM\ManyToMany(targetEntity: Milestone::class, inversedBy: 'attempts')]
    private Collection $milestones;

    public function __construct()
    {
        $this->milestones = new ArrayCollection();
    }

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

    public function getCharacterId(): ?Character
    {
        return $this->characterId;
    }

    public function setCharacterId(?Character $characterId): static
    {
        $this->characterId = $characterId;

        return $this;
    }

    /**
     * @return Collection<int, Milestone>
     */
    public function getMilestones(): Collection
    {
        return $this->milestones;
    }

    public function addMilestone(Milestone $milestone): static
    {
        if (!$this->milestones->contains($milestone)) {
            $this->milestones->add($milestone);
        }

        return $this;
    }

    public function removeMilestone(Milestone $milestone): static
    {
        $this->milestones->removeElement($milestone);

        return $this;
    }
}
