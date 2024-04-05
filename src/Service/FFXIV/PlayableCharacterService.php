<?php

namespace App\Service\FFXIV;

use App\Entity\FFXIV\PlayableCharacter;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

class PlayableCharacterService
{

    private $serializer;

    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager
        )
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    public function serialize_playablecharacter(PlaybaleCharacter $character): array
    {
        return [
            'id' => $character->getId(),
            'name' => $character->getName(),
            'last_name' => $character->getLastName(),
            'world' => $character->getWorld(),
            'lodestone_url' => $character->getLodestoneUrl(),
        ];
    }

    public function deserialize_playablecharacter($data): PlayableCharacter
    {
        $character = $this->serializer->deserialize($data, PlayableCharacter::class, 'json');

        return $character;
    }

    public function savePlayableCharacter($data): ?PlayableCharacter
    {
        $character = $this->entityManager->getRepository(PlayableCharacter::class)
        ->findOneBy([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'world' => $data['world']
        ]);

        // check if character exists
        if ($character !== null)
        {
            return $character;
        }

        $character = new PlayableCharacter();
        $character->setName($data['name']);
        $character->setLastName($data['last_name']);
        $character->setLodestoneUrl($data['lodestone_url']);
        $character->setWorld($data['world']);

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $character;
    }
}