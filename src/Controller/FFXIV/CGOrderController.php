<?php

namespace App\Controller\FFXIV;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\FFXIV\PlayableCharacter;
use App\Entity\FFXIV\Item;
use App\Entity\FFXIV\DiscordUser;
use App\Entity\FFXIV\CGOrderItem;
use App\Entity\FFXIV\CGOrder;
use App\Entity\FFXIV\Customer;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\FFXIV\CGOrderRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PropertyAccess\PropertyAccess;


#[Route('/ffxiv')]
class CGOrderController extends AbstractController
{
    private $doctrine;
    private $serializer;

    public function __construct(ManagerRegistry $doctrine, SerializerInterface $serializer, #[Autowire(service: ObjectNormalizer::class)]
        ObjectNormalizer $normalizer)
    {
        $this->doctrine = $doctrine;
        $this->serializer = $serializer;

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $this->normalizer = new ObjectNormalizer(null, null, $propertyAccessor);
    }

    #[Route('/add_gcorder', name: 'add_gathering_crafting_order', methods: ['POST'])]
    public function add_gcorder(Request $request, SerializerInterface $serializer): Response
    {
        // Deserialize JSON data into an associative array
        $jsonData = json_decode($request->getContent(), true);

        // Retrieve data for PlayableCharacter from JSON
        $characterData = $jsonData['PlayableCharacter'];
        $entityManager = $this->doctrine->getManager('ffxiv');
        $characterRepository = $entityManager->getRepository(PlayableCharacter::class);
        $character = $characterRepository->findOneBy([
            'name' => $characterData['name'],
            'last_name' => $characterData['last_name'],
            'world' => $characterData['world']
        ]);

        if (!$character) {
            $character = new PlayableCharacter();
            $character->setName($characterData['name']);
            $character->setLastName($characterData['last_name']);
            $character->setLodestoneUrl($characterData['lodestone_url'] ?? null);
            $character->setWorld($characterData['world']);
            $entityManager->persist($character);
        }

        $discordUserData = $jsonData['DiscordUser'];
        $discordUserRepository = $entityManager->getRepository(DiscordUser::class);
        $discordUser = $discordUserRepository->findOneBy([
            'username' => $discordUserData['username']
        ]);

        if (!$discordUser) {
            $discordUser = new DiscordUser();
            $discordUser->setUsername($discordUserData['username']);
            $entityManager->persist($discordUser);
        }

        // Extract data for CGOrder
        $cgOrderData = $jsonData['CGOrder'];
        $cgOrder = new CGOrder();
        $cgOrder->setStatus($cgOrderData['status']);
        $cgOrder->setReward($cgOrderData['reward']);

        $customerRepository = $entityManager->getRepository(Customer::class);
        $customer = $customerRepository->findOneBy([
            'PlayableCharacter' => $character,
            'DiscordInfo' => $discordUser
        ]);

        if(!$customer) {
            $customer = new Customer();
            $customer->setPlayableCharacter($character);
            $customer->setDiscordInfo($discordUser);
        }

        $cgOrder->setCustomer($customer);

        foreach ($jsonData['CGOrderItem'] as $itemData) {
            $item = new Item();
            $itemInfo = $itemData['Item'];

            $itemRepository = $entityManager->getRepository(Item::class);
            $item = $itemRepository->findOneBy([
                'name' => $itemInfo['name']
            ]);

            if (!$item) {
                $item = new Item();
                $item->setId($itemInfo['id']);
                $item->setName($itemInfo['name']);
                $item->setDescription($itemInfo['description']);
                $item->setIsCollectable($itemInfo['isCollectable']);
            }
            
            $cgOrderItem = new CGOrderItem();
            $cgOrderItem->setAmount($itemData['amount']);
            $cgOrderItem->addItem($item);
            $cgOrderItem->addCGOrder($cgOrder);

            $entityManager->persist($cgOrderItem);
        }

        $entityManager->persist($cgOrder);
        $entityManager->flush();

        return $this->json([
            'message' => 'CGOrder created successfully',
            'id' => $cgOrder->getId(),
        ]);
        
        $cgOrderItem->addCGOrder($cgOrder);
    
        $entityManager = $this->doctrine->getManager('ffxiv');
        $entityManager->persist($character);
        $entityManager->persist($item);
        $entityManager->persist($discordUser);
        $entityManager->persist($customer);
        $entityManager->persist($cgOrder);
        $entityManager->flush();

        return $this->json([
            'message' => 'CGOrder created successfully',
            'id' => $cgOrder->getId(),
        ]);
    }

    #[Route('/get_cgorder/{id}', name: 'get_gathering_crafting_order', methods: ['GET'])]
    public function get_gcorder(int $id, CGOrderRepository $cgOrderRepository): JsonResponse
    {
        $cgOrder = $cgOrderRepository->find($id);

        if (!$cgOrder) {
            return new JsonResponse(['message' => 'Order not found'], 404);
        }

        $serializedData = $this->serializeData($cgOrder);
        return new JsonResponse($serializedData);
    }

    public function serializeData(CGOrder $cgOrder): array
    {
        $character = $cgOrder->getCustomer()->getPlayableCharacter();
        $discordUser = $cgOrder->getCustomer()->getDiscordInfo();
        $cgOrderItems = $cgOrder->getCGOrderItems();

        $serializedCharacter = [
            'PlayableCharacter' => [
                'id' => $character->getId(),
                'name' => $character->getName(),
                'last_name' => $character->getLastName(),
                'world' => $character->getWorld(),
                'lodestone_url' => $character->getLodestoneUrl(),
            ]
        ];

        $serializedDiscordUser = [
            'DiscordUser' => [
                'id' => $discordUser->getId(),
                'username' => $discordUser->getUsername(),
            ]
        ];

        $serializedCgOrderItems = [];
        foreach ($cgOrderItems as $cgOrderItem) {
            $item = $cgOrderItem->getItem();
            $serializedItem = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'description' => $item->getDescription(),
                'isCollectable' => $item->isIsCollectable(),
                'CanBeHQ' => $item->isCanBeHQ()
            ];

            $serializedCgOrderItems[] = [
                'amount' => $cgOrderItem->getAmount(),
                'Item' => $serializedItem,
            ];
        }

        $serializedCgOrder = [
            'CGOrder' => [
                'id' => $cgOrder->getId(),
                'status' => $cgOrder->getStatus(),
                'reward' => $cgOrder->getReward(),
                'customer_id' => $cgOrder->getCustomer()->getId(),
            ]
        ];

        $serializedData = array_merge(
            $serializedCharacter,
            $serializedDiscordUser,
            ['CGOrderItem' => 
                $serializedCgOrderItems],
            $serializedCgOrder
        );

        return $serializedData;
    }
}