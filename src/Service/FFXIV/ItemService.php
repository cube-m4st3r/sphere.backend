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

    public function saveItem(array $itemData): void
    {
        $item = new Item();
        $item->setId($itemData['GamePatch']['ID']);
        $item->setName($itemData['Name']);
        $item->setDescription($itemData['Description']);
        $item->setIsCollectable($itemData['IsCollectable']);
        $item->setCanBeHQ($itemData['CanBeHq']);

        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }
}
