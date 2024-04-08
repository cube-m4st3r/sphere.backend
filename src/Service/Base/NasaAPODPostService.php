<?php
// src/Service/NasaAPODPostService.php

namespace App\Service\Base;

use App\Entity\Base\NasaAPODPost;
use Doctrine\ORM\EntityManagerInterface;

class NasaAPODPostService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addToDB($data): void
    {
        $post = new NasaAPODPost();
        $post->setTitle($data["title"]);
        $post->setExplanation($data["explanation"]);
        if (isset($data["copyright"])) {
            $post->setCopyright($data["copyright"]);
        }
        $post->setDate($data["date"]);
        $post->setUrl($data["url"]);
        $post->setColor(1);

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}
