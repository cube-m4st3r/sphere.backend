<?php

namespace App\Service\FFXIV;

use App\Entity\FFXIV\Item;
use Doctrine\ORM\EntityManagerInterface;

class ItemService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function serialize_item(Item $item): array
    {
        return([
            'id' => $item->getId(),
            'name' => $item->getName(),
            'description' => $item->getDescription(),
            'isCollectable' => $item->isIsCollectable(),
            'CanBeHQ' => $item->isCanBeHQ()
        ]);
    }

    public function saveItem(array $itemData): ?Item
    {
        $item = new Item();
        $item->setId($itemData['ID']);
        $item->setName($itemData['Name']);
        $item->setDescription($itemData['Description']);
        $item->setIsCollectable($itemData['IsCollectable']);
        $item->setCanBeHQ($itemData['CanBeHq']);

        $this->entityManager->persist($item);

        return $item;
    }
}
