<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\VislandRouteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: VislandRouteRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['visland_route:read']],
    denormalizationContext: ['groups' => ['visland_route:write']]
)]
#[ApiFilter(SearchFilter::class, properties: ['vislandRouteItems.item.name' => 'partial'])]
class VislandRoute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['visland_route:read',
    'discord_user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read',
    'location:read'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    private ?int $steps = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    private ?string $pastebinlink = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['visland_route:read', 'visland_route:write', 
    'discord_user:read'])]
    private ?\DateTimeImmutable $lastUpdatedAt = null;

    #[ORM\ManyToOne(targetEntity: DiscordUser::class, inversedBy: 'createdRoutes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visland_route:read', 'visland_route:write'])]
    private ?DiscordUser $creator = null;

    #[ORM\ManyToOne(targetEntity: DiscordUser::class, inversedBy: 'updatedRoutes')]
    #[Groups(['visland_route:read', 'visland_route:write'])]
    private ?DiscordUser $updater = null;

    #[ORM\OneToMany(targetEntity: VislandRouteItem::class, mappedBy: 'route')]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read'])]
    private Collection $vislandRouteItems;

    #[ORM\Column(type: Types::TEXT)]
    //#[Groups(['visland_route:read', 'visland_route:write',    // unnecessary data output because pastebinlink is handling the code
    //'discord_user:read'])]                                    // keeping lines in need of debugging
    private ?string $routeCode = null;

    #[ORM\ManyToOne(targetEntity: Location::class, inversedBy: 'vislandRoutes', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['visland_route:read', 'visland_route:write',
    'discord_user:read',
    'location:read'])]
    private ?Location $location = null;

    public function __construct()
    {
        $this->vislandRouteItems = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->lastUpdatedAt = new \DateTimeImmutable();
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

    public function getCreatedAt(): ?string
    {   
        // temp fix to return DateTimeImmutable
        return $this->createdAt ? $this->createdAt->format('Y-m-d H:i:s') : null;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastUpdatedAt(): ?string
    {   
        // temp fix to return DateTimeImmutable
        return $this->lastUpdatedAt ? $this->lastUpdatedAt->format('Y-m-d H:i:s') : null;
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
    public function getVislandRouteItems(): Collection
    {
        return $this->vislandRouteItems;
    }

    public function addVislandRouteItem(VislandRouteItem $vislandRouteItem): static
    {
        if (!$this->vislandRouteItems->contains($vislandRouteItem)) {
            $this->vislandRouteItems->add($vislandRouteItem);
            $vislandRouteItem->setRoute($this);
        }

        return $this;
    }

    public function removeVislandRouteItem(VislandRouteItem $vislandRouteItem): static
    {
        if ($this->vislandRouteItems->removeElement($vislandRouteItem)) {
            // set the owning side to null (unless already changed)
            if ($vislandRouteItem->getRoute() === $this) {
                $vislandRouteItem->setRoute(null);
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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }
}