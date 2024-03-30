<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\CGOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CGOrderRepository::class)]
class CGOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cGOrders', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $Customer = null;


    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?int $reward = null;

    #[ORM\OneToMany(targetEntity: CGOrderItem::class, mappedBy: 'CGOrder')]
    private Collection $cGOrderItems;

    public function __construct()
    {
        $this->cGOrderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->Customer;
    }

    public function setCustomer(?Customer $Customer): static
    {
        $this->Customer = $Customer;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getReward(): ?int
    {
        return $this->reward;
    }

    public function setReward(int $reward): static
    {
        $this->reward = $reward;

        return $this;
    }

    /**
     * @return Collection<int, CGOrderItem>
     */
    public function getCGOrderItems(): Collection
    {
        return $this->cGOrderItems;
    }

    public function addCGOrderItem(CGOrderItem $cGOrderItem): static
    {
        if (!$this->cGOrderItems->contains($cGOrderItem)) {
            $this->cGOrderItems->add($cGOrderItem);
            $cGOrderItem->addCGOrder($this);
        }

        return $this;
    }

    public function removeCGOrderItem(CGOrderItem $cGOrderItem): static
    {
        if ($this->cGOrderItems->removeElement($cGOrderItem)) {
            $cGOrderItem->removeCGOrder($this);
        }

        return $this;
    }
}
