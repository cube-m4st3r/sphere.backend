<?php

namespace App\Entity\FFXIV;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FFXIV\DiscordUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DiscordUserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['discord_user:read']],
    denormalizationContext: ['groups' => ['discord_user:write']],
)]
class DiscordUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['visland_route:read',
    'discord_user:read', 'discord_user:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read', 'discord_user:write'])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read', 'discord_user:write'])]
    private ?string $avatarUrl = null;

    #[ORM\OneToMany(targetEntity: VislandRoute::class, mappedBy: 'creator')]
    #[Groups(['discord_user:read', 'discord_user:write'])]
    private $createdRoutes;

    #[ORM\OneToMany(targetEntity: VislandRoute::class, mappedBy: 'updater')]
    #[Groups(['discord_user:read', 'discord_user:write'])]
    private $updatedRoutes;

    public function __construct()
    {
        $this->createdRoutes = new ArrayCollection();
        $this->updatedRoutes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(string $avatarUrl): static
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    /**
     * @return Collection|VislandRoute[]
     */
    public function getCreatedRoutes(): Collection
    {
        return $this->createdRoutes;
    }

    /**
     * @return Collection|VislandRoute[]
     */
    public function getUpdatedRoutes(): Collection
    {
        return $this->updatedRoutes;
    }
}
