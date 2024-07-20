<?php

namespace App\Command\FFXIV;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\FFXIV\Item;
use App\Service\FFXIV\ItemService;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'Insert_Items',
    description: 'Inserts items to the database with a .csv file',
)]
class InsertItemsCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private ItemService $itemService;

    public function __construct(
        EntityManagerInterface $entityManager,
        ItemService $itemService
    )
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->itemService = $itemService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ini_set('memory_limit', '1024M');

        $csvFilePath = __DIR__ . '/Items.csv';

        if (!file_exists($csvFilePath)) {
            $output->writeln('File not found: ' . $csvFilePath);
            return Command::FAILURE;
        }

        $csvFileContents = file_get_contents($csvFilePath);

        if (($handle = fopen($csvFilePath, "r")) !== false) {
            fgetcsv($handle, 1000, ",");

            $header_line2 = fgetcsv($handle, 1000, ",");
            fgetcsv($handle, 1000, ",");
            fgetcsv($handle, 1000, ",");
            fgetcsv($handle, 1000, ",");

            $normalizedHeader_line2 = array_map('trim', $header_line2);
            $normalizedHeader_line2 = array_map('strtolower', $normalizedHeader_line2);

            $keyColumnIndex = array_search('#', $normalizedHeader_line2);
            if ($keyColumnIndex === false) {
                $output->writeln('Key column not found.');
                return Command::FAILURE;
            }
            
            $nameColumnIndex = array_search('name', $normalizedHeader_line2);
            if ($nameColumnIndex === false) {
                $output->writeln('Name column not found.');
                return Command::FAILURE;
            }

            $descriptionColumnIndex = array_search('description', $normalizedHeader_line2);
            if ($descriptionColumnIndex === false) {
                $output->writeln('Description column not found.');
                return Command::FAILURE;
            }

            $isCollectableColumnIndex = array_search('iscollectable', $normalizedHeader_line2);
            if ($isCollectableColumnIndex === false) {
                $output->writeln('isCollectable column not found.');
                return Command::FAILURE;
            }

            $canBeHQColumnIndex = array_search('canbehq', $normalizedHeader_line2);
            if ($canBeHQColumnIndex === false) {
                $output->writeln('canBeHQ column not found.');
                return Command::FAILURE;
            }
    
            $batchSize = 100;
            $rowCount = 0;
            $addedItems = 0;
            $lines = file($csvFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $rowAmount = count($lines);

            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $itemID = $data[$keyColumnIndex] ?? 'N/A';
                $itemName = $data[$nameColumnIndex] ?? 'N/A';
                $itemDescription = $data[$descriptionColumnIndex] ?? 'N/A';
                $itemIsCollectable = $data[$isCollectableColumnIndex] ?? 'N/A';
                $itemCanBeHQ = $data[$canBeHQColumnIndex] ?? 'N/A';

                $itemIsCollectableInt = filter_var($itemIsCollectable, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
                $itemCanBeHQInt = filter_var($itemCanBeHQ, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

                $this->itemService->saveItem($itemData = [
                    'ID' => (int)$itemID,
                    'Name' => $itemName,
                    'Description' => $itemDescription,
                    'IsCollectable' => $itemIsCollectableInt,
                    'CanBeHq' => $itemCanBeHQInt
                ]);

                if (($rowCount % $batchSize) === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                    $addedItems = $addedItems + $rowCount;
                    $output->writeln($addedItems . "/" . $rowAmount . " items added.");
                    $rowCount = 0;
                }
                $rowCount++;

                //$output->writeln('ID: ' . $itemID . ' | ' . 'Name: ' . $itemName . ' | ' . 'Description: ' . $itemDescription . ' | ' . 'IsCollectable: ' . $itemIsCollectable . ' | ' . 'CanBeHQ: ' . $itemCanBeHQ);
            }
            fclose($handle);
            $this->entityManager->flush();
            $this->entityManager->clear();

            $io->success('CSV data imported successfully.');
        } else {
            $output->writeln('Unable to open the file.');
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
}
