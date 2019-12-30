<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Read;

use Ds\Vector;
use Todo\ShareSpace\Domain\Read\ReadModel;

final class TodoList implements ReadModel
{
    private string $identifier;
    private string $name;
    private int $taskCount;

    /** @var Vector<Task> */
    private Vector $tasks;

    /**
     * @param array<Task> $tasks
     */
    public function __construct(string $identifier, string $name, int $taskCount, array $tasks = [])
    {
        $this->identifier = $identifier;
        $this->name = $name;
        $this->taskCount = $taskCount;
        /** @var Vector<Task> $vectorTasks */
        $vectorTasks = new Vector($tasks);
        $this->tasks = $vectorTasks;
    }

    /**
     * @return array<mixed>
     */
    public function normalize(): array
    {
        return [
            'identifier' => $this->identifier,
            'name' => $this->name,
            'task_count' => $this->taskCount,
            'tasks' => $this->tasks->map(fn (Task $task): array => $task->normalize())->toArray(),
        ];
    }
}
