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
    private $discordUserService;
    private $serializer;
    private $entityManager;

    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        PasteBinService $pasteBinService,
        DiscordUserService $discordUserService
        )
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->pasteBinService = $pasteBinService;
        $this->discordUserService = $discordUserService;
    }

    public function serialize_vislandroute(VislandRoute $route): array
    {
        $creator = $this->entityManager->getRepository(DiscordUser::class)
        ->findOneBy([
            'id' => $route->getCreator()->getId(),
            'username' => $route->getCreator()->getUsername()
        ]);

        $updater = $this->entityManager->getRepository(DiscordUser::class)
        ->findOneBy([
            'id' => $route->getCreator()->getId(),
            'username' => $route->getCreator()->getUsername()
        ]);

        $creatorSerialized = $this->discordUserService->serialize_discorduser($creator);
        $updaterSerialized = $this->discordUserService->serialize_discorduser($updater);

        // serialize the main route object
        $serializedRoute = [
            'id' => $route->getId(),
            'name' => $route->getName(),
            'steps' => $route->getSteps(),
            'pasteBinLink' => $route->getPastebinlink(),
            'createdAt' => $route->getCreatedAt(),
            'lastUpdatedAt' => $route->getLastUpdatedAt(),
            'creator' => $creatorSerialized,
            'updater' => $updaterSerialized,
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

            $route->setCreator($creator);
        } else {
            throw new \Exception('Creator not found');
        }

        $updater = $this->entityManager->getRepository(DiscordUser::class)
        ->findOneBy([
            'username' => $routeData['updater']
        ]);

        
        if ($updater instanceof DiscordUser) {
            $route->setUpdater($updater);
        } else {
            throw new \Exception('Updater not found');
        }

        $route->setRouteCode($routeData['routeCode']);
        $pastebinlink = $this->pasteBinService->create_paste($routeData['routeCode'], "N");
        $route->setPasteBinLink($pastebinlink);

        foreach ($routeData['VislandRouteItems'] as $routeItemData) {
            $itemName = $routeItemData['Item']['name'];

            $item = $this->entityManager->getRepository(Item::class)
                ->findOneBy(['name' => $itemName]);

            if (!$item) {
                $item = new Item();
                $item->setName($itemName);
                $this->entityManager->persist($item);
            }

            $routeItem = new VislandRouteItem();
            $routeItem->setRoute($route);
            $routeItem->setItem($item);
            $this->entityManager->persist($routeItem);
        }

        $this->entityManager->persist($route);
        $this->entityManager->flush();

        return $route;
    }
}