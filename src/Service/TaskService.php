<?php

namespace App\Service;

use App\Entity\Developer;
use App\Entity\Task;
use App\Repository\DeveloperRepository;
use App\Repository\TaskRepository;

class TaskService
{
    const WEEKLY_WORKING_HOURS = 45;

    /**
     * @var TaskRepository
     */
    private $taskRepository;

    /**
     * @var DeveloperRepository
     */
    private $developerRepository;

    public function __construct(TaskRepository $taskRepository, DeveloperRepository $developerRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->developerRepository = $developerRepository;
    }

    public function getDevelopers(): array
    {
        return $this->developerRepository->findBy([], ['level' => 'DESC']);
    }

    public function getTasks(): array
    {
        return $this->taskRepository->findBy([], ['level' => 'DESC', 'estimatedDuration' => 'DESC']);
    }

    public function getWeeklyPlan(): array
    {
        $developers = $this->getDevelopers();
        $tasks = $this->getTasks();
        $todoList = [];
        $week = 1;

        while ($tasks) {
            /** @var Developer $developer */
            foreach ($developers as $developer) {
                $hour = 0;

                /** @var Task $task */
                foreach ($tasks as $index => $task) {
                    $isDeveloperCompleteWeek = $hour + $task->getEstimatedDuration() > self::WEEKLY_WORKING_HOURS;
                    $isCanDeveloperDoTheTask = $task->getLevel() <= $developer->getLevel();

                    if (!$isDeveloperCompleteWeek && $isCanDeveloperDoTheTask) {
                        $todoList[$week][$developer->getName()][] = $task->getTitle();
                        $hour += $task->getEstimatedDuration();
                        unset($tasks[$index]);
                    }
                }
            }

            $week++;
        }

        return $todoList;
    }
}