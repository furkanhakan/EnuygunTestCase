<?php

namespace App\Type;

class TaskDTO
{
    /** @var string */
    private $title;

    /** @var int */
    private $level;

    /** @var int */
    private $estimatedDuration;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return TaskDTO
     */
    public function setTitle(string $title): TaskDTO
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     * @return TaskDTO
     */
    public function setLevel(int $level): TaskDTO
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return int
     */
    public function getEstimatedDuration(): int
    {
        return $this->estimatedDuration;
    }

    /**
     * @param int $estimatedDuration
     * @return TaskDTO
     */
    public function setEstimatedDuration(int $estimatedDuration): TaskDTO
    {
        $this->estimatedDuration = $estimatedDuration;
        return $this;
    }
}