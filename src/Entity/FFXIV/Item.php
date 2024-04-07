<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 999, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isCollectable = null;

    #[ORM\Column]
    private ?bool $CanBeHQ = null;

    #[ORM\OneToMany(targetEntity: VislandRouteItem::class, mappedBy: 'Item_id')]
    private Collection $VislandRouteItem_id;

    public function __construct()
    {
        $this->VislandRouteItem_id = new ArrayCollection();
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
     * @return Collection<int, VislandRouteItem>
     */
    public function getVislandRouteItemId(): Collection
    {
        return $this->VislandRouteItem;
    }

    public function addVislandRouteItemId(VislandRouteItem $vislandRouteItemId): static
    {
        if (!$this->VislandRouteItem->contains($vislandRouteItemId)) {
            $this->VislandRouteItem->add($vislandRouteItemId);
            $vislandRouteItemId->setItemId($this);
        }

        return $this;
    }

    public function removeVislandRouteItemId(VislandRouteItem $vislandRouteItemId): static
    {
        if ($this->VislandRouteItem->removeElement($vislandRouteItemId)) {
            // set the owning side to null (unless already changed)
            if ($vislandRouteItemId->getItemId() === $this) {
                $vislandRouteItemId->setItemId(null);
            }
        }

        return $this;
    }
}
