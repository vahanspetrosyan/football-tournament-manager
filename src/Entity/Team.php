<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: "team1", targetEntity: "FMatch", orphanRemoval: true)]
    private $matchesAsTeam1;

    #[ORM\OneToMany(mappedBy: "team2", targetEntity: "FMatch", orphanRemoval: true)]
    private $matchesAsTeam2;

    public function __construct()
    {
        $this->matchesAsTeam1 = new ArrayCollection();
        $this->matchesAsTeam2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
