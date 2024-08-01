<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\VislandRouteItemRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: VislandRouteItemRepository::class)]
#[ApiResource]
class VislandRouteItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['visland_route:read',
    'discord_user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: VislandRoute::class, inversedBy: 'vislandRouteItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    #[Ignore]
    private ?VislandRoute $route = null;

    #[ORM\ManyToOne(targetEntity: Item::class, inversedBy: 'vislandRouteItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    private ?Item $item = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoute(): ?VislandRoute
    {
        return $this->route;
    }

    public function setRoute(?VislandRoute $route): static
    {
        $this->route = $route;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): static
    {
        $this->item = $item;

        return $this;
    }
}
