<?php

namespace App\Controller\FFXIV;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FFXIV\VislandService;
use App\Entity\FFXIV\VislandRoute;
use App\Entity\FFXIV\Item;
use App\Repository\FFXIV\VislandRouteRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/ffxiv')]
class VislandController extends AbstractController
{
    private $vislandService;
    private $entityManager;

    public function __construct(
        VislandService $vislandService,
        EntityManagerInterface $entityManager
        )
    {
        $this->vislandService = $vislandService;
        $this->entityManager = $entityManager;
    }

    #[Route('/visland/route/add', name: 'add_visland_route', methods: ['POST'])]
    public function add_visland_route(Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        $route = $this->vislandService->saveVislandRoute($jsonData);

        return $this->json([
            'message' => 'VislandRoute created successfully',
            'id' => $route->getID(),
        ]);
    }

    // temp debug route
    /*#[Route('/visland/route/{id}', name: 'get_route_data', methods: ['GET'])]
    public function get_visland_route(int $id, VislandRouteRepository $vislandRouteRepository): JsonResponse
    {
        $vislandRoute = $vislandRouteRepository->find($id);

        if (!$vislandRoute)
        {
            return new JsonResponse(['message' => 'VislandRoute unavailable/not found.', 404]);
        }

        $serializedData = $this->vislandService->serialize_vislandroute($vislandRoute);
        return new JsonResponse($serializedData);
    }*/

    #[Route('/visland/route/search', name: 'search_route_with_item', methods: ['GET'])]
    public function search_route_with_item(Request $request)
    {
        $item = $this->entityManager->getRepository(Item::class)
        ->findOneBy([
            'name' => $request->query->get('item_name')
        ]);

        if($item)
        {
            $vislandRouteItems = $item->getVislandRouteItem();

            foreach ($vislandRouteItems as $vislandRouteItem) {
                $vislandRoute = $vislandRouteItem->getRoute();
            }
            return new JsonResponse($this->vislandService->serialize_vislandroute($vislandRoute), 200);
        } 
        else 
        {
            return new JsonResponse(['message' => "Couldn't find a matching item."], 404);
        }
    }
}
