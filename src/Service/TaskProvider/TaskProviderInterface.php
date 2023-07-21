<?php

namespace App\Service\TaskProvider;

interface TaskProviderInterface
{
    public function getProviderCode(): string;
    public function getTasks(): array;
    public function prepareTaskDTO(array $tasks): array;
}