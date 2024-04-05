<?php

namespace App\Controller\FFXIV;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\FFXIV\Customer;
use App\Entity\FFXIV\DiscordUser;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FFXIV\CustomerService;

class CustomerController extends AbstractController
{

    private $doctrine;
    private CustomerService $customerService;

    public function __construct(
        ManagerRegistry $doctrine, 
        CustomerService $customerService)
    {
        $this->doctrine = $doctrine;
        $this->customerService = $customerService;
        $this->entityManagerFFXIV = $doctrine->getManager('ffxiv');
    }

    #[Route('/ffxiv/customer', name: 'get_customer')]
    public function get_uster_character(Request $request): JsonResponse
    {
        $userData = $request->query->get('user');

        $discordUser = $this->entityManagerFFXIV->getRepository(DiscordUser::class)->findOneBy(['username' => $userData]);

        $customer = $this->entityManagerFFXIV->getRepository(Customer::class)->findOneBy(['DiscordInfo' => $discordUser]);

        $serialized_customer = $this->customerService->serialize_customer($customer);

        if ($customer) {
            return new JsonResponse($serialized_customer, 200);
        } else {
            return new JsonResponse(['message' => 'Customer not found'], 404);
        }
    }
}