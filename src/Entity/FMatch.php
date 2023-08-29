<?php

namespace App\Entity;

use App\Repository\FMatchRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FMatchRepository::class)]
class FMatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $team1;

    #[ORM\ManyToOne(targetEntity: Team::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $team2;

    #[ORM\Column(type: "datetime")]
    private $date;

    #[ORM\ManyToOne(targetEntity: Tournament::class, inversedBy: "matches")]
    #[ORM\JoinColumn(nullable: false)]
    private $tournament;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam1(): ?Team
    {
        return $this->team1;
    }

    public function setTeam1(?Team $team1): self
    {
        $this->team1 = $team1;
        return $this;
    }

    public function getTeam2(): ?Team
    {
        return $this->team2;
    }

    public function setTeam2(?Team $team2): self
    {
        $this->team2 = $team2;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }
    public function setDate($date): static
    {
        $this->date = $date;

        return $this;
    }

    public function setTournament(Tournament $tournament): static
    {
        $this->tournament = $tournament;
        return $this;
    }
}
