<?php
// src/EventListener/DateTimeEventListener.php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpClient\HttpClient;


class DateTimeEventListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        // Get current date and time
        $currentDateTime = new \DateTime();

        // Example: Check if it's after 5 PM
        $hour = (int) $currentDateTime->format('H');
        if ($hour >= 22) {
            // Trigger Discord webhook
            $this->triggerDiscordWebhook();
        }
    }

    private function triggerDiscordWebhook()
    {
        $webhookUrl = 'https://discord.com/api/webhooks/1210279735641514045/h-5-JO6AHzIQ918_7J2-u_FP7SxDS8Jf512rkEBbprFYMpSVNz97oHA3p8xwmznID11F';
        $data = [
            'content' => 'This is a message sent from Symfony at ' . date('Y-m-d H:i:s'),
        ];

        $client = HttpClient::create();
        $client->request('POST', $webhookUrl, ['json' => $data]);
    }
}
