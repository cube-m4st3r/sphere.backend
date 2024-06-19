<?php 

// [ ] method to check if data exists
// [ ] method to insert into database
// [ ] method to update database in case of different datasets



namespace App\Service\Anime;

use App\Entity\Anime\AnimeShow;


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
                    return $anime;
                }
            }
        }
    }  
}