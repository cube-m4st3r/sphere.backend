<?php

namespace App\Controller\Anime;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Anime\AnimeShow;
use App\Service\Anime\AnimeExtAPIService;
use App\Service\Anime\AnimeShowService;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/anime')]
class AnimeShowController extends AbstractController
{
    private $doctrine;
    private $AnimeExtAPIService;
    private $AnimeShowService;
    private $entityManagerAnime;

    public function __construct(
        ManagerRegistry $doctrine,
        AnimeExtAPIService $AnimeExtAPIService,
        AnimeShowService $AnimeShowService,
        EntityManagerInterface $entityManagerAnime
        )
    {
        $this->doctrine = $doctrine;
        $this->entityManagerAnime = $entityManagerAnime;
        $this->entityManagerAnime = $doctrine->getManager('anime');
        $this->AnimeExtAPIService = $AnimeExtAPIService;
        $this->AnimeShowService = $AnimeShowService;
    }


    #[Route('/search', name: 'search_anime_show', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('q');
        #$this->entityManagerAnime->getRepository(AnimeShow::class)->findOneBy(['title' => $query]);
        $dataset = $this->AnimeExtAPIService->getAnimeSearch($query);

        if ($dataset) {
            return new JsonResponse($this->AnimeShowService->filter_anime_data_by_title($dataset, $query), 200);
        } else {
            return new JsonResponse(['message' => 'Anime not found'], 404);
        }
    }

    #[Route('/add', name: 'add_anime_show', methods: ['POST'])]
    public function add_anime(Request $request): Response
    {
        $jsonData = json_decode($request->getContent(), true);
    }
}
