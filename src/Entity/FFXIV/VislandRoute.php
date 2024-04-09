<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\VislandRouteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VislandRouteRepository::class)]
class VislandRoute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $steps = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $pastebinlink = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $last_updated_at = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?DiscordUser $creator = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?DiscordUser $updater = null;

    #[ORM\OneToMany(targetEntity: VislandRouteItem::class, mappedBy: 'Route')]
    private Collection $VislandRouteItem;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $routeCode = null;

    public function __construct()
    {
        $this->Item = new ArrayCollection();
    }

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

    public function getSteps(): ?int
    {
        return $this->steps;
    }

    public function setSteps(int $steps): static
    {
        $this->steps = $steps;

        return $this;
    }

    public function getPastebinlink(): ?string
    {
        return $this->pastebinlink;
    }

    public function setPastebinlink(string $pastebinlink): static
    {
        $this->pastebinlink = $pastebinlink;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->last_updated_at;
    }

    public function setLastUpdatedAt(\DateTimeImmutable $last_updated_at): static
    {
        $this->last_updated_at = $last_updated_at;

        return $this;
    }

    public function getCreator(): ?DiscordUser
    {
        return $this->creator;
    }

    public function setCreator(DiscordUser $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    public function getUpdater(): ?DiscordUser
    {
        return $this->updater;
    }

    public function setUpdater(?DiscordUser $updater): static
    {
        $this->updater = $updater;

        return $this;
    }

    /**
     * @return Collection<int, VislandRouteItem>
     */
    public function getVislandRouteItem(): Collection
    {
        return $this->VislandRouteItem;
    }

    public function addVislandRouteItem(VislandRouteItem $vislandrouteitem): static
    {
        if (!$this->VislandRouteItem->contains($vislandrouteitem)) {
            $this->VislandRouteItem->add($vislandrouteitem);
            $vislandrouteitem->setRoute($this);
        }

        return $this;
    }

    public function removeVislandRouteItem(VislandRouteItem $vislandrouteitem): static
    {
        if ($this->VislandRouteItem->removeElement($vislandrouteitem)) {
            // set the owning side to null (unless already changed)
            if ($vislandrouteitem->getRoute() === $this) {
                $vislandrouteitem->setRoute(null);
            }
        }

        return $this;
    }

    public function getRouteCode(): ?string
    {
        return $this->routeCode;
    }

    public function setRouteCode(string $routeCode): static
    {
        $this->routeCode = $routeCode;

        return $this;
    }
}
