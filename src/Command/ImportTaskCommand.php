<?php

namespace App\Command;

use App\Service\TaskProvider\TaskProviderFactory;
use App\Service\TaskProvider\TaskProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportTaskCommand extends Command
{
    protected static $defaultName = 'import:task';
    protected static $defaultDescription = 'Add a short description for your command';

    /**
     * @var TaskProviderFactory
     */
    private $taskProviderFactory;

    private $providers = [
        'provider1',
        'provider2',
    ];

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    public function __construct(string $name = null, TaskProviderFactory $taskProviderFactory)
    {
        parent::__construct($name);
        $this->taskProviderFactory = $taskProviderFactory;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        foreach ($this->providers as $providerCode) {
            /** @var TaskProviderInterface $provider */
            if (!$provider = $this->taskProviderFactory->buildTaskService($providerCode)) {
                $io->error('Provider service not found: ' . $providerCode);
                continue;
            }

            $tasks = $provider->getTasks();
            foreach ($tasks as $task) {
                $provider->saveDatabase($task);
            }
        }

        return 0;
    }
}
