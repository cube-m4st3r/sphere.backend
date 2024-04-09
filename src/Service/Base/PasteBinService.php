<?php

namespace App\Service\Base;
use GuzzleHttp\Client;

class PasteBinService
{
    public function create_paste($textToUpload){
        $config = [
            'verify' => __DIR__ . '/cacert.pem',
        ];
    
        $apiKey = $_ENV['PASTEBIN_API_KEY'];
    
        $client = new Client($config);
        $response = $client->request('POST', 'https://pastebin.com/api/api_post.php', [
            'form_params' => [
                'api_dev_key' => $apiKey,
                'api_option' => 'paste',
                'api_paste_code' => $textToUpload,
                'api_paste_expire_date' => '10M'
            ]
        ]);
    
        return $pasteUrl = $response->getBody()->getContents();
    }
}