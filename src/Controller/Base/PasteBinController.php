<?php

namespace App\Controller\Base;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use GuzzleHttp\Client;

#[Route("/base")]
class PasteBinController extends AbstractController
{
    
    #[Route("/postpaste", name: "post_to_pastebin")]
    public function postToPastebin(): Response
    {
        $config = [
            'verify' => __DIR__ . '/../cacert.pem',
        ];

        $apiKey = $_ENV['PASTEBIN_API_KEY'];
        $textToUpload = 'testpaste';

        $client = new Client($config);
        $response = $client->request('POST', 'https://pastebin.com/api/api_post.php', [
            'form_params' => [
                'api_dev_key' => $apiKey,
                'api_option' => 'paste',
                'api_paste_code' => $textToUpload,
                'api_paste_expire_date' => '10M'
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $pasteUrl = $response->getBody()->getContents();

        // Assuming you want to return the paste URL as the response
        return new Response($pasteUrl, $statusCode);
    }
}
