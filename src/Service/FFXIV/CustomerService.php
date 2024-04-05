<?php

namespace App\Service\FFXIV;

use App\Service\FFXIV\DiscordUserService;
use App\Service\FFXIV\PlayableCharacterService;
use App\Entity\FFXIV\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CustomerService
{
    private $discordUserService;
    private $playableCharacterService;

    public function __construct(
        DiscordUserService $discordUserService,
        PlayableCharacterService $playableCharacterService,
        EntityManagerInterface $entityManager
    ) {
        $this->discordUserService = $discordUserService;
        $this->playableCharacterService = $playableCharacterService;
        $this->enttityManager = $entityManager;
    }

    public function serialize_customer(Customer $customer): array
    {
        $character = $customer->getPlayableCharacter();
        $discordUser = $customer->getDiscordInfo();

        return([
            'CustomerData' => [
                'id' => $customer->getId(),
            ],
            'PlayableCharacter' => [
                'id' => $character->getId(),
                'name' => $character->getName(),
                'last_name' => $character->getLastName(),
                'world' => $character->getWorld(),
                'lodestone_url' => $character->getLodestoneUrl(),
            ],
            'DiscordUser' => [
                'id' => $discordUser->getId(),
                'username' => $discordUser->getUsername(),
            ]
        ]);
    }

    public function saveCustomer(array $customerData): void
    {
        $character = $this->playableCharacterService->savePlayableCharacter($customerData['PlayableCharacter']);
        $user = $this->discordUserService->saveDiscordUser($customerData['DiscordInfo']);

        $customer = new Customer();
        $customer->setPlayableCharacter($character);
        $customer->setDiscordInfo($user);

        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }
}