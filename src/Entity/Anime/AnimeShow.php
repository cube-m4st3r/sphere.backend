<?php

namespace App\Entity\Anime;

use App\Repository\Anime\AnimeShowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimeShowRepository::class)]
class AnimeShow
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $episodes_amount = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $aired_start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $aired_end = null;

    #[ORM\Column(length: 255)]
    private ?string $premiered = null;

    #[ORM\Column(length: 255)]
    private ?string $broadcast = null;

    #[ORM\Column(length: 255)]
    private ?string $source = null;

    #[ORM\OneToMany(targetEntity: AnimeShowGenres::class, mappedBy: 'animeshow')]
    private Collection $animeshowgenres;

    #[ORM\OneToMany(targetEntity: AnimeShowThemes::class, mappedBy: 'animeshow')]
    private Collection $animeshowthemes;

    public function __construct()
    {
        $this->animegenres = new ArrayCollection();
        $this->animeshowthemes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEpisodesAmount(): ?int
    {
        return $this->episodes_amount;
    }

    public function setEpisodesAmount(int $episodes_amount): static
    {
        $this->episodes_amount = $episodes_amount;

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

    public function getAiredStart(): ?\DateTimeInterface
    {
        return $this->aired_start;
    }

    public function setAiredStart(\DateTimeInterface $aired_start): static
    {
        $this->aired_start = $aired_start;

        return $this;
    }

    public function getAiredEnd(): ?\DateTimeInterface
    {
        return $this->aired_end;
    }

    public function setAiredEnd(?\DateTimeInterface $aired_end): static
    {
        $this->aired_end = $aired_end;

        return $this;
    }

    public function getPremiered(): ?string
    {
        return $this->premiered;
    }

    public function setPremiered(string $premiered): static
    {
        $this->premiered = $premiered;

        return $this;
    }

    public function getBroadcast(): ?string
    {
        return $this->broadcast;
    }

    public function setBroadcast(string $broadcast): static
    {
        $this->broadcast = $broadcast;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return Collection<int, AnimeShowGenres>
     */
    public function getAnimeShowGenres(): Collection
    {
        return $this->animeshowgenres;
    }

    public function addAnimeShowGenre(AnimeShowGenres $animeshowgenre): static
    {
        if (!$this->animeshowgenres->contains($animeshowgenre)) {
            $this->animeshowgenres->add($animeshowgenre);
            $animeshowgenre->setAnimeshow($this);
        }

        return $this;
    }

    public function removeAnimedataset(AnimeShowGenres $animeshowgenre): static
    {
        if ($this->animeshowgenres->removeElement($animeshowgenre)) {
            // set the owning side to null (unless already changed)
            if ($animeshowgenre->getAnimeshow() === $this) {
                $animeshowgenre->setAnimeshow(null);
            }
        }

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
            $animeshowtheme->setAnimeshow($this);
        }

        return $this;
    }

    public function removeAnimeshowtheme(AnimeShowThemes $animeshowtheme): static
    {
        if ($this->animeshowthemes->removeElement($animeshowtheme)) {
            // set the owning side to null (unless already changed)
            if ($animeshowtheme->getAnimeshow() === $this) {
                $animeshowtheme->setAnimeshow(null);
            }
        }

        return $this;
    }
}
