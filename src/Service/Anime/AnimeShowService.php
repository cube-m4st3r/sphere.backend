<?php 

// [ ] method to check if data exists
// [ ] method to insert into database
// [ ] method to update database in case of different datasets



namespace App\Service\Anime;

use App\Entity\Anime\AnimeShow;
use App\Entity\Anime\AnimeThemes;
use App\Entity\Anime\AnimeGenres;
use App\Entity\Anime\AnimeShowGenres;
use App\Entity\Anime\AnimeShowThemes;


class AnimeShowService
{
    public function __construct(
    ){

    }
    
    public function filter_anime_data_by_title($dataset, $animeTitle): array
    {
        // check if 'data' key exists
        if (!isset($dataset['data']) || !is_array($dataset['data'])) {
            return null;
        }

        foreach ($dataset['data'] as $anime) {
            if (!isset($anime['titles']) && is_array($anime['titles'])) {
                return null;
            }

            foreach ($anime['titles'] as $title) {
                if ($title['type'] === 'English' && $title['title'] === $animeTitle) {
                    //return $anime;
                    return($this->serialize_anime_show($this->convert_raw_to_entity($anime)));
                }
            }
        }
    }  

    public function convert_raw_to_entity($dataset): AnimeShow
    {
        $anime_show = new AnimeShow();
        $show_themes = new AnimeThemes();
        $anime_show_themes = new AnimeShowThemes();

        $anime_show->setTitle($dataset['title_english']);
        $anime_show->setType($dataset['type']);
        $anime_show->setEpisodesAmount($dataset['episodes']);
        $anime_show->setStatus($dataset['status']);
        $anime_show->setAiredStart(\DateTime::createFromFormat(\DateTime::ISO8601, $dataset['aired']['from']));
        $anime_show->setAiredEnd(\DateTime::createFromFormat(\DateTime::ISO8601, $dataset['aired']['to']));
        $anime_show->setPremiered("N/A"); // fix, temp N/A
        $anime_show->setBroadcast($dataset['broadcast']['string']);
        $anime_show->setSource($dataset['source']);

        $theme = $dataset['themes'][0];
        $show_themes->setName($theme['name']);
        $anime_show_themes->setAnimeshow($anime_show);
        $anime_show_themes->setAnimethemes($show_themes);

        $anime_show->addAnimeshowtheme($anime_show_themes);
        
        foreach ($dataset['genres'] as $genre) {
            $show_genres = new AnimeGenres();
            $show_genres->setName($genre['name']);

            $anime_show_genres = new AnimeShowGenres();
            $anime_show_genres->setAnimeshow($anime_show);
            $anime_show_genres->setAnimegenre($show_genres);

            $anime_show->addAnimeShowGenre($anime_show_genres);
        }

        return $anime_show;
    }

    public function serialize_anime_show(AnimeShow $show): array
    {
        $serializedAnimeShow = [
            'anime_show' => [
                'id' => ($show->getId() != '') ? $show->getId() : 'N/A',
                'title' => $show->getTitle(), 
                'type' => $show->getType(),
                'eps_amount' => $show->getEpisodesAmount(),
                'status' => $show->getStatus(),
                'aired_start' => $show->getAiredStart(),
                'aired_end' => $show->getAiredEnd(),
                'premiered' => $show->getPremiered(),
                'broadcast' => $show->getBroadcast(),
                'source' => $show->getSource()
            ]
        ];

        $serializedAnimeThemes = [];
        $anime_show_themes = $show->getAnimeshowthemes();
        foreach ($anime_show_themes as $theme) {
            $serializedAnimeThemes[] = [
                'theme' => $theme->getAnimethemes()->getName()
            ];
        }

        $serializedAnimeGenres = [];
        $anime_show_genres = $show->getAnimeShowGenres();
        foreach ($anime_show_genres as $genre) {
            $serializedAnimeGenres[] = [
                'genre' => $genre->getAnimegenre()->getName()
            ];
        }

        return array_merge(
            $serializedAnimeShow,
            ['themes' => 
                $serializedAnimeThemes],
            ['genres' => 
                $serializedAnimeGenres]
        );
    }
}