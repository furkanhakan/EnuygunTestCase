<?php

namespace App\Service\TaskProvider\Provider1;

use App\Service\TaskProvider\AbstractTaskProvider;
use App\Type\TaskDTO;

class Provider1Service extends AbstractTaskProvider
{
    public $providerCode = 'provider1';

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
            $taskDTOList[] = (new TaskDTO())
                ->setTitle($task['id'])
                ->setLevel($task['zorluk'])
                ->setEstimatedDuration($task['sure']);
        }

        return $taskDTOList;
    }
}