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
    private ?DiscordUser $creatorID = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?DiscordUser $updaterID = null;

    #[ORM\OneToMany(targetEntity: VislandRouteItem::class, mappedBy: 'Route_id')]
    private Collection $VislandRouteItem;

    public function __construct()
    {
        $this->Item_id = new ArrayCollection();
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

    public function getCreatorID(): ?DiscordUser
    {
        return $this->creatorID;
    }

    public function setCreatorID(DiscordUser $creatorID): static
    {
        $this->creatorID = $creatorID;

        return $this;
    }

    public function getUpdaterID(): ?DiscordUser
    {
        return $this->updaterID;
    }

    public function setUpdaterID(?DiscordUser $updaterID): static
    {
        $this->updaterID = $updaterID;

        return $this;
    }

    /**
     * @return Collection<int, VislandRouteItem>
     */
    public function getVislandRouteItemId(): Collection
    {
        return $this->VislandRouteItem;
    }

    public function addVislandRouteItemId(VislandRouteItem $vislandrouteitemId): static
    {
        if (!$this->VislandRouteItem->contains($vislandrouteitemId)) {
            $this->VislandRouteItem->add($vislandrouteitemId);
            $vislandrouteitemId->setRouteId($this);
        }

        return $this;
    }

    public function removeItemId(VislandRouteItem $vislandrouteitemId): static
    {
        if ($this->VislandRouteItem->removeElement($vislandrouteitemId)) {
            // set the owning side to null (unless already changed)
            if ($vislandrouteitemId->getRouteId() === $this) {
                $vislandrouteitemId->setRouteId(null);
            }
        }

        return $this;
    }
}
