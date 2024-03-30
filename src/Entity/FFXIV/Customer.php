<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?PlayableCharacter $PlayableCharacter = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?DiscordUser $DiscordInfo = null;

    #[ORM\OneToMany(targetEntity: CGOrder::class, mappedBy: 'Customer')]
    private Collection $cGOrders;

    public function __construct()
    {
        $this->cGOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayableCharacter(): ?PlayableCharacter
    {
        return $this->PlayableCharacter;
    }

    public function setPlayableCharacter(PlayableCharacter $PlayableCharacter): static
    {
        $this->PlayableCharacter = $PlayableCharacter;

        return $this;
    }

    public function getDiscordInfo(): ?DiscordUser
    {
        return $this->DiscordInfo;
    }

    public function setDiscordInfo(DiscordUser $DiscordInfo): static
    {
        $this->DiscordInfo = $DiscordInfo;

        return $this;
    }

    /**
     * @return Collection<int, CGOrder>
     */
    public function getCGOrders(): Collection
    {
        return $this->cGOrders;
    }

    public function addCGOrder(CGOrder $cGOrder): static
    {
        if (!$this->cGOrders->contains($cGOrder)) {
            $this->cGOrders->add($cGOrder);
            $cGOrder->setCustomer($this);
        }

        return $this;
    }

    public function removeCGOrder(CGOrder $cGOrder): static
    {
        if ($this->cGOrders->removeElement($cGOrder)) {
            if ($cGOrder->getCustomer() === $this) {
                $cGOrder->setCustomer(null);
            }
        }

        return $this;
    }
}
