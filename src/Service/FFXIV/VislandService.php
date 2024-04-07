<?php

namespace App\Service\FFXIV;

use App\Entity\FFXIV\VislandRoute;
use App\Entity\FFXIV\VislandRouteItem;
use Doctrine\ORM\EntityManagerInterface;

class VislandService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveVislandRoute(array $routeData): ?VislandRoute
    {
        $route = new VislandRoute();
        $route->setName($routeData['name']);
        $route->setSteps($routeData['stepAmount']);
        #$route->setPastebinlin() # needs a function & pastebin service to generate
        $route->setCreatedAt($routeData['createdAt']);
        $route->setCreatorID($routeData['userID']);

        return $route;
    }

    public function saveRouteWithItems(array $itemData, array $routeData): void
    {
        $route = saveVislandRoute($routeData);

        foreach($itemData as $item)
        {
            $item = $this->entityManager->getRepository(Item::class)
            ->findOneBy([
                'name' => $item
            ]);
            
            $routeWithItems = new VislandRouteItem();
            $routeWithItems->setRoute($route);
            $routeWithItems->setItem($item);
        }
    }
}