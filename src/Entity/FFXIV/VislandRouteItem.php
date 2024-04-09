<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\VislandRouteItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VislandRouteItemRepository::class)]
class VislandRouteItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Item_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VislandRoute $Route = null;

    #[ORM\ManyToOne(inversedBy: 'VislandRouteItem_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $Item = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoute(): ?VislandRoute
    {
        return $this->Route;
    }

    public function setRoute(?VislandRoute $Route): static
    {
        $this->Route = $Route;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->Item;
    }

    public function setItem(?Item $Item): static
    {
        $this->Item = $Item;

        return $this;
    }
}
