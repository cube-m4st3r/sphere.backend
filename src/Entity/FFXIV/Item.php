<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ApiResource]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['visland_route:read',
    'discord_user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    private ?bool $isCollectable = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    private ?bool $CanBeHQ = null;

    #[ORM\OneToMany(targetEntity: VislandRouteItem::class, mappedBy: 'item')]
    private Collection $vislandRouteItems;

    public function __construct()
    {
        $this->vislandRouteItems = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isIsCollectable(): ?bool
    {
        return $this->isCollectable;
    }

    public function setIsCollectable(bool $isCollectable): static
    {
        $this->isCollectable = $isCollectable;

        return $this;
    }

    public function isCanBeHQ(): ?bool
    {
        return $this->CanBeHQ;
    }

    public function setCanBeHQ(bool $CanBeHQ): static
    {
        $this->CanBeHQ = $CanBeHQ;

        return $this;
    }

    /**
     * @return Collection<int, vislandRouteItems>
     */
    public function getVislandRouteItem(): Collection
    {
        return $this->vislandRouteItems;
    }

    public function addVislandRouteItem(VislandRouteItem $vislandRouteItem): static
    {
        if (!$this->vislandRouteItems->contains($vislandRouteItem)) {
            $this->vislandRouteItems->add($vislandRouteItem);
            $vislandRouteItem->setItem($this);
        }

        return $this;
    }

    public function removeVislandRouteItem(VislandRouteItem $vislandRouteItem): static
    {
        if ($this->VislandRouteItem->removeElement($vislandRouteItem)) {
            // set the owning side to null (unless already changed)
            if ($vislandRouteItem->getItem() === $this) {
                $vislandRouteItem->setItem(null);
            }
        }

        return $this;
    }
}