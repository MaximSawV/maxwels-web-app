<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 11/25/21
 * Time: 2:30 PM
 */

namespace App\Entity;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    protected $task;
    protected $dueDate;

    public function getTask(): string
    {
        return $this->task;
    }

    public function setTask(string $task): void
    {
        $this->task = $task;
    }

    public function getDueDate(): ?\DateTime
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTime $dueDate): void
    {
        $this->dueDate = $dueDate;
    }
}