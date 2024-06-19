<?php

namespace App\Entity\Anime;

use App\Repository\Anime\AnimeThemesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimeThemesRepository::class)]
class AnimeThemes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: AnimeShowThemes::class, mappedBy: 'animethemes')]
    private Collection $animeshowthemes;

    public function __construct()
    {
        $this->animeshowthemes = new ArrayCollection();
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

    /**
     * @return Collection<int, AnimeShowThemes>
     */
    public function getAnimeshowthemes(): Collection
    {
        return $this->animeshowthemes;
    }

    public function addAnimeshowtheme(AnimeShowThemes $animeshowtheme): static
    {
        if (!$this->animeshowthemes->contains($animeshowtheme)) {
            $this->animeshowthemes->add($animeshowtheme);
            $animeshowtheme->setAnimethemes($this);
        }

        return $this;
    }

    public function removeAnimeshowtheme(AnimeShowThemes $animeshowtheme): static
    {
        if ($this->animeshowthemes->removeElement($animeshowtheme)) {
            // set the owning side to null (unless already changed)
            if ($animeshowtheme->getAnimethemes() === $this) {
                $animeshowtheme->setAnimethemes(null);
            }
        }

        return $this;
    }
}
