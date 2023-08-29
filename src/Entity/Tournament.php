<?php

namespace App\Entity;

use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    private ?string $slug = null;


    #[ORM\OneToMany(mappedBy: "tournament", targetEntity: FMatch::class, cascade: ["remove"])]
    private $matches;

    public function __construct()
    {
        $this->matches = new ArrayCollection();
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

        $slugger = new AsciiSlugger();
        $this->slug = $slugger->slug($name);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getMatches(): Collection
    {
        return $this->matches;
    }
}
