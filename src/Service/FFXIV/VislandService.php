<?php

namespace App\Service\FFXIV;

use App\Entity\FFXIV\VislandRoute;
use App\Entity\FFXIV\VislandRouteItem;
use App\Entity\FFXIV\DiscordUser;
use App\Entity\FFXIV\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\Base\PasteBinService;

class VislandService
{
    private $pasteBinService;
    private $serializer;
    private $entityManager;

    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        PasteBinService $pasteBinService)
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->pasteBinService = $pasteBinService;
    }

    public function serialize_vislandroute(VislandRoute $route): array
{
        // Serialize the main route object
        $serializedRoute = [
            'id' => $route->getId(),
            'name' => $route->getName(),
            'steps' => $route->getSteps(),
            'pasteBinLink' => $route->getPastebinlink(),
            'createdAt' => $route->getCreatedAt(),
            'lastUpdatedAt' => $route->getLastUpdatedAt(),
            'creator' => $route->getCreator(),
            'updater' => $route->getUpdater(),
            'code' => $route->getRouteCode(),
        ];

        // Serialize each VislandRouteItem associated with the route
        $serializedVislandRouteItems = [];
        foreach ($route->getVislandRouteItem() as $vislandRouteItem) {
            $serializedItem = $this->serialize_vislandrouteitem($vislandRouteItem->getItem());
            $serializedVislandRouteItems[] = [
                'Item' => $serializedItem
            ];
        }

        // Add the serialized VislandRouteItems to the main serialized route data
        $serializedRoute['VislandRouteItems'] = $serializedVislandRouteItems;

        return $serializedRoute;
    }

    public function serialize_vislandrouteitem(Item $item)
    {   
        return [
            'id' => $item->getId(),
            'name' => $item->getName()
        ];
    }

    public function deserialize_vislandroute(array $data): VislandRoute
    {
        $serializedData = json_encode($data);
        $route = $this->serializer->deserialize($serializedData, VislandRoute::class, 'json');

        return $route;
    }

    public function saveVislandRoute(array $routeData): ?VislandRoute
    {
        // Create a new VislandRoute instance
        $route = new VislandRoute();
        $route->setName($routeData['name']);
        $route->setSteps($routeData['steps']);
        $route->setPasteBinLink($routeData['pasteBinLink']);
        
        // Convert createdAt and lastUpdatedAt to DateTimeImmutable
        $createdAt = new \DateTimeImmutable($routeData['createdAt']);
        $lastUpdatedAt = new \DateTimeImmutable($routeData['lastUpdatedAt']);
        $route->setCreatedAt($createdAt);
        $route->setLastUpdatedAt($lastUpdatedAt);

        // Retrieve the DiscordUser entity for the creator
        $creator = $this->entityManager->getRepository(DiscordUser::class)
        ->findOneBy([
            'username' => $routeData['creator']
        ]);

        // Check if the creator exists
        if ($creator instanceof DiscordUser) {
            // Set the creator for the VislandRoute entity
            $route->setCreator($creator);
        } else {
            // Handle the case where the creator is not found (e.g., throw an exception)
            throw new \Exception('Creator not found');
        }

        // Retrieve the DiscordUser entity for the updater
        $updater = $this->entityManager->getRepository(DiscordUser::class)
        ->findOneBy([
            'username' => $routeData['updater']
        ]);

        // Check if the updater exists
        if ($updater instanceof DiscordUser) {
            // Set the updater for the VislandRoute entity
            $route->setUpdater($updater);
        } else {
            // Handle the case where the updater is not found (e.g., throw an exception)
            throw new \Exception('Updater not found');
        }

        // Set the route code
        $route->setRouteCode($routeData['routeCode']);

        // Loop through VislandRouteItems in routeData and associate them with the route
        foreach ($routeData['VislandRouteItems'] as $routeItemData) {
            $itemName = $routeItemData['Item']['name'];

            // Find or create the item entity
            $item = $this->entityManager->getRepository(Item::class)
                ->findOneBy(['name' => $itemName]);

            if (!$item) {
                // Create a new item entity if it doesn't exist
                $item = new Item();
                $item->setName($itemName);
                // Set any other properties of the item entity if needed
                // $item->setProperty($routeItemData['Item']['property']);
                $this->entityManager->persist($item);
            }

            // Create a new VislandRouteItem entity and associate it with the route and item
            $routeItem = new VislandRouteItem();
            $routeItem->setRoute($route);
            $routeItem->setItem($item);
            $this->entityManager->persist($routeItem);
        }

        // Persist the route and associated items
        $this->entityManager->persist($route);
        $this->entityManager->flush();

        return $route;
    }
}