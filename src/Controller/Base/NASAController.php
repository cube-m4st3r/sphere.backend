<?php
// src/Controller/NASAController.php
namespace App\Controller\Base;

use App\Entity\Base\NasaAPODPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use App\Repository\Base\NasaAPODPostRepository;
use App\Service\Base\NasaAPODPostService;


class NASAController extends AbstractController
{
    #[Route('/nasa/apod/get_latest_post', name: 'get_latest_post')]
    public function getLatestPost(EntityManagerInterface $entityManager, NasaAPODPostRepository $repository,
    NasaAPODPostService $nasaAPODPostService): Response
    {
        $config = [
            'verify' => __DIR__ . '/../cacert.pem',
        ];

        $client = new Client($config);

        $response = $client->request('GET', 'https://api.nasa.gov/planetary/apod', [
            'query' => [
                'api_key' => 'L0Lpnt6lS7Hyg5AedHOJYMQITStlXM1ZPl0Mvrd9',
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        $earliestEntity = $repository->findEarliestDateEntity();

        if ($earliestEntity !== null) // if there are no datasets in the DB
        {
            $date = DateTime::createFromFormat('Y-m-d', $earliestEntity->getDate());
            if (!$date) {
                // Handle invalid date format
                throw new \InvalidArgumentException('Invalid date format');
            }

            if (new DateTime('today') > $date)
            {
                $nasaAPODPostService->addToDB($data);
            }
        } 
        else 
        {
            $nasaAPODPostService->addToDB($data);
        }

        return $this->json($data);
    }
}
