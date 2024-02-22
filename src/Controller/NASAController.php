<?php
// src/Controller/NASAController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use Symfony\Component\Routing\Annotation\Route;

class NASAController extends AbstractController
{
    #[Route('/nasa/apod')]
    public function index(): Response
    {
        $config = [
            'verify' => __DIR__ . '/cacert.pem',
        ];

        $client = new Client($config);

        $response = $client->request('GET', 'https://api.nasa.gov/planetary/apod', [
            'query' => [
                'api_key' => 'L0Lpnt6lS7Hyg5AedHOJYMQITStlXM1ZPl0Mvrd9',
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        return $this->json($data);
    }
}
