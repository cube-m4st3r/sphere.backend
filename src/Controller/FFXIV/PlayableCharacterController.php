<?php

namespace App\Controller\FFXIV;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PlayableCharacterController extends AbstractController
{
    #[Route('/ffxiv/playable/character', name: 'appffxivplayable_character')]
    public function index(): JsonResponse
    {
        
    }
}
