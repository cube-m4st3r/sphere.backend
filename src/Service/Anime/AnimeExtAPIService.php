<?php

namespace App\Service\Anime;

use GuzzleHttp\Client;

class AnimeExtAPIService
{
    public function getAnimeSearch($query){

        // validate and sanitize input to prevent malicious intent
        $validatedQuery = filter_var($query, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $config = [
            'verify' => __DIR__ . '/cacert.pem',
        ];

        $client = new Client($config);
        $response = $client->request('GET', 'https://api.jikan.moe/v4/anime', [
            'query' => [
                'q' => $validatedQuery
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}