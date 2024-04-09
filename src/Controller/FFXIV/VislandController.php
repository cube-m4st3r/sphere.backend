<?php

namespace App\Controller\FFXIV;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FFXIV\VislandService;

#[Route('/ffxiv')]
class VislandController extends AbstractController
{
    private $vislandService;

    // Inject VislandService through constructor
    public function __construct(VislandService $vislandService)
    {
        $this->vislandService = $vislandService;
    }

    #[Route('/visland/add', name: 'add_visland_route', methods: ['POST'])]
    public function add_visland_route(Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        $route = $this->vislandService->saveVislandRoute($jsonData);

        return $this->json([
            'message' => 'VislandRoute created successfully',
            'id' => $route->getID(),
        ]);
    }

    #[Route('visland/route/{id}', name: 'get_route_data', methods: ['GET'])]
    public function get_visland_route(): JsonResponse
    {

    }
}
