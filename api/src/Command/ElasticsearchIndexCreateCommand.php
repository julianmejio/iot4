<?php

namespace App\Command;

use JoliCode\Elastically\Client;
use JoliCode\Elastically\IndexBuilder;
use JoliCode\Elastically\Indexer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:elasticsearch:index:create',
    description: 'Creates the Elasticsearch index',
)]
class ElasticsearchIndexCreateCommand extends Command
{
    public function __construct(
        private readonly IndexBuilder $indexBuilder,
    ){
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $index = $this->indexBuilder->createIndex('door_event');
        $this->indexBuilder->markAsLive($index, 'door_event');
        return Command::SUCCESS;
    }
}
