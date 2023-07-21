<?php

namespace App\Service\TaskProvider;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Type\TaskDTO;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

abstract class AbstractTaskProvider implements TaskProviderInterface
{
    /**
     * @var ParameterBagInterface
     */
    protected $parameterBag;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    public function __construct(ParameterBagInterface $parameterBag, TaskRepository $taskRepository)
    {
        $this->parameterBag = $parameterBag;
        $this->taskRepository = $taskRepository;
    }

    public function request(string $method, string $endPoint, array $options = [])
    {
        try {
            $client = new Client([
                'timeout' => 30
            ]);

            $apiResponse = $client->request($method, $endPoint, $options);

            return json_decode($apiResponse->getBody()->getContents(), 1);
        } catch (\Exception $exception) {
            return [];
        }
    }

    public function saveDatabase(TaskDTO $taskDTO)
    {
        $task = $this->taskRepository->findOneBy(['title' => $taskDTO->getTitle()]);
        if (!($task instanceof Task)) {
            $task = (new Task())
                ->setTitle($taskDTO->getTitle())
                ->setCreatedAt(new \DateTime());
        }

        $task
            ->setLevel($taskDTO->getLevel())
            ->setEstimatedDuration($taskDTO->getEstimatedDuration())
            ->setUpdatedAt(new \DateTime());

        $this->taskRepository->add($task);
    }

    public function getParameters()
    {
        return $this->parameterBag->get($this->getProviderCode());
    }
}