<?php

namespace App\Service\Base;
use GuzzleHttp\Client;

class PasteBinService
{
    public function create_paste($textToUpload, $expireDate){
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
                // possible expire date types
                // N = Never
                // 10M = 10 Minutes
                // 1H = 1 Hour
                // 1D = 1 Day
                // 1W = 1 Week
                // 2W = 2 Weeks
                // 1M = 1 Month
                // 6M = 6 Months
                // 1Y = 1 Year
                'api_paste_expire_date' => $expireDate
            ]
        ]);
    
        return $pasteUrl = $response->getBody()->getContents();
    }
}