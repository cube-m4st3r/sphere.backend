<?php
// src/Controller/DiscordController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class DiscordController extends AbstractController
{
    #[Route('/send-message', name: 'send_message')]
    public function sendMessage(): Response
    {
        // Replace 'YOUR_WEBHOOK_URL' with your actual webhook URL
        $webhookUrl = 'https://discord.com/api/webhooks/1210279735641514045/h-5-JO6AHzIQ918_7J2-u_FP7SxDS8Jf512rkEBbprFYMpSVNz97oHA3p8xwmznID11F';

        // Message to be sent
        $message = [
            'content' => 'Hello from Symfony!'
        ];

        // Send a POST request to the webhook URL with the message data
        $httpClient = HttpClient::create();
        $response = $httpClient->request('POST', $webhookUrl, [
            'json' => $message,
        ]);

        // Check if the request was successful
        if ($response->getStatusCode() === 204) {
            return new Response('Message sent successfully', Response::HTTP_OK);
        } else {
            return new Response('Failed to send message', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
