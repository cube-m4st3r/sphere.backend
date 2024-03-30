<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\PlayableCharacterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayableCharacterRepository::class)]
class PlayableCharacter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $lodestone_url = null;

    #[ORM\Column(length: 255)]
    private ?string $world = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getLodestoneUrl(): ?string
    {
        return $this->lodestone_url;
    }

    public function setLodestoneUrl(string $lodestone_url): static
    {
        $this->lodestone_url = $lodestone_url;

        return $this;
    }

    public function getWorld(): ?string
    {
        return $this->world;
    }

    public function setWorld(string $world): static
    {
        $this->world = $world;

        return $this;
    }
}
