<?php

namespace App\Entity\Anime;

use App\Repository\Anime\AnimeGenresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimeGenresRepository::class)]
class AnimeGenres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: AnimeShowGenres::class, mappedBy: 'animegenre')]
    private Collection $animegenre;

    public function __construct()
    {
        $this->animegenre = new ArrayCollection();
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
     * @return Collection<int, AnimeShowGenres>
     */
    public function getAnimegenre(): Collection
    {
        return $this->animegenre;
    }

    public function addAnimegenre(AnimeShowGenres $animegenre): static
    {
        if (!$this->animegenre->contains($animegenre)) {
            $this->animegenre->add($animegenre);
            $animegenre->setAnimegenre($this);
        }

        return $this;
    }

    public function removeAnimegenre(AnimeShowGenres $animegenre): static
    {
        if ($this->animegenre->removeElement($animegenre)) {
            // set the owning side to null (unless already changed)
            if ($animegenre->getAnimegenre() === $this) {
                $animegenre->setAnimegenre(null);
            }
        }

        return $this;
    }
}
