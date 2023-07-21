<?php

namespace App\Service\TaskProvider;

use Psr\Container\ContainerInterface;

class TaskProviderFactory
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * BankTransferSoapFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function buildTaskService(string $providerName)
    {
        try {
            return $this->container->get(sprintf('%s_service', $providerName));
        } catch (\Exception $exception) {
            return null;
        }
    }
}