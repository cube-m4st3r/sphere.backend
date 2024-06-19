<?php

namespace App\Entity\Anime;

use App\Repository\Anime\AnimeShowThemesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimeShowThemesRepository::class)]
class AnimeShowThemes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'animeshowthemes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimeShow $animeshow = null;

    #[ORM\ManyToOne(inversedBy: 'animeshowthemes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimeThemes $animethemes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimeshow(): ?AnimeShow
    {
        return $this->animeshow;
    }

    public function setAnimeshow(?AnimeShow $animeshow): static
    {
        $this->animeshow = $animeshow;

        return $this;
    }

    public function getAnimethemes(): ?AnimeThemes
    {
        return $this->animethemes;
    }

    public function setAnimethemes(?AnimeThemes $animethemes): static
    {
        $this->animethemes = $animethemes;

        return $this;
    }
}
