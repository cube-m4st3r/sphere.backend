<?php

namespace App\Service\FFXIV;

use App\Entity\FFXIV\DiscordUser;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

class DiscordUserService
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

    public function serialize_discorduser(DiscordUser $user)
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
        ];
    }

    public function deserialize_discorduser($data): DiscordUser
    {
        $user = $this->serializer->deserialize($data, DiscordUser::class, 'json');

        return $user;
    }

    public function saveDiscordUser($data): ?DiscordUser
    {
        $user = $entityManager->getRepository(DiscordUser::class)
        ->findOneBy([
            'username' => $data['username'],
        ]);

        // check if user exists
        if ($user !== null)
        {
            return $user;
        }

        $user = new DiscordUser();
        $user->setUsername($data['username']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}