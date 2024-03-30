<?php
namespace App\Entity\FFXIV;

use App\Repository\FFXIV\CGOrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CGOrderItemRepository::class)]
class CGOrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: CGOrder::class, inversedBy: 'cGOrderItems')]
    private ?CGOrder $CGOrder = null;

    #[ORM\ManyToOne(targetEntity: Item::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $Item = null;

    #[ORM\Column]
    private ?int $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCGOrder(): ?CGOrder
    {
        return $this->CGOrder;
    }

    public function addCGOrder(CGOrder $cGOrder): void
    {
        $this->CGOrder = $cGOrder;
    }

    public function removeCGOrder(CGOrder $cGOrder): static
    {
        $this->CGOrder->removeElement($cGOrder);

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->Item;
    }

    public function addItem(Item $item): self
    {
        $this->Item = $item;
        return $this;
    }

    public function removeItem(Item $item): self
    {
        $this->Item->removeElement($item);
        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;
        return $this;
    }
}
