<?php

namespace App\Entity\FFXIV;

use App\Repository\FFXIV\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['location:read']]
)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['location:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['location:read', 
    'visland_route:read'])]
    private ?LocationMainArea $MainArea = null;

    #[ORM\ManyToOne(inversedBy: 'locations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['location:read',
    'visland_route:read'])]
    private ?LocationSubArea $SubArea = null;

    #[ORM\OneToMany(targetEntity: VislandRoute::class, mappedBy: 'location')]
    #[Groups(['location:read'])]
    private Collection $vislandRoutes;

    public function __construct()
    {
        $this->vislandRoutes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainArea(): ?LocationMainArea
    {
        return $this->MainArea;
    }

    public function setMainArea(?LocationMainArea $MainArea): static
    {
        $this->MainArea = $MainArea;

        return $this;
    }

    public function getSubArea(): ?LocationSubArea
    {
        return $this->SubArea;
    }

    public function setSubArea(?LocationSubArea $SubArea): static
    {
        $this->SubArea = $SubArea;

        return $this;
    }

    /**
     * @return Collection<int, VislandRoute>
     */
    public function getVislandRoutes(): Collection
    {
        return $this->vislandRoutes;
    }

    public function addVislandRoute(VislandRoute $vislandRoute): static
    {
        if (!$this->vislandRoutes->contains($vislandRoute)) {
            $this->vislandRoutes->add($vislandRoute);
            $vislandRoute->setLocation($this);
        }

        return $this;
    }

    public function removeVislandRoute(VislandRoute $vislandRoute): static
    {
        if ($this->vislandRoutes->removeElement($vislandRoute)) {
            // set the owning side to null (unless already changed)
            if ($vislandRoute->getLocation() === $this) {
                $vislandRoute->setLocation(null);
            }
        }

        return $this;
    }
}
