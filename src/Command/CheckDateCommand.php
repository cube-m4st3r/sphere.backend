<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'CheckDate',
    description: 'Checks if desired date has been reached and triggers a discord webhook.',
)]
class CheckDateCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Checks if the desired date has been reached.')
            ->setHelp('This command sends a message to a Discord channel.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Logic to check if the desired date has been reached
        $desiredDate = new \DateTime('2024-02-23');
        $currentDate = new \DateTime();

        if ($currentDate >= $desiredDate) {
            // Desired date has been reached, trigger the action (e.g., send Discord webhook)
            $this->sendDiscordWebhook();

            // Output message
            $output->writeln('Desired date reached. Discord webhook sent.');
        } else {
            // Output message
            $output->writeln('Desired date not yet reached.');
        }

        return Command::SUCCESS;
    }

    private function sendDiscordWebhook()
    {
        $webhookUrl = 'https://discord.com/api/webhooks/1210279735641514045/h-5-JO6AHzIQ918_7J2-u_FP7SxDS8Jf512rkEBbprFYMpSVNz97oHA3p8xwmznID11F';
        $data = [
            'content' => 'This is a message sent from Symfony at ' . date('Y-m-d H:i:s'),
        ];

        $client = HttpClient::create();
        $client->request('POST', $webhookUrl, ['json' => $data]);
    }
}
