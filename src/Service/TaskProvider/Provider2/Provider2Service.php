<?php

namespace App\Service\TaskProvider\Provider2;

use App\Service\TaskProvider\AbstractTaskProvider;
use App\Service\TaskProvider\TaskProviderInterface;
use App\Type\TaskDTO;

class Provider2Service extends AbstractTaskProvider implements TaskProviderInterface
{
    public $providerCode = 'provider2';

    public function getProviderCode(): string
    {
        return $this->providerCode;
    }

    public function getTasks(): array
    {
        $response = $this->request('GET', $this->getParameters()['url']);

        return $this->prepareTaskDTO($response);
    }

    public function prepareTaskDTO(array $tasks): array
    {
        $taskDTOList = [];
        foreach ($tasks as $task) {
            $title = key($task);
            $taskDTOList[] = (new TaskDTO())
                ->setTitle($title)
                ->setLevel($task[$title]['level'])
                ->setEstimatedDuration($task[$title]['estimated_duration']);
        }

        return $taskDTOList;
    }
}