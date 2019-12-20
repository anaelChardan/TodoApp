<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Domain\TodoList\Write;

use Ds\Set;
use Todo\Todo\Domain\TodoList\Write\Task\Task;

/**
 * @psalm-suppress TooManyTemplateParams
 */
class TodoList
{
    private Identifier $identifier;
    private Name $name;
    /** @var Set<Task> */
    private Set $tasks;

    /**
     * @psalm-suppress MixedPropertyTypeCoercion
     */
    public function __construct(Identifier $identifier, Name $name)
    {
        $this->identifier = $identifier;
        $this->name = $name;
        $this->tasks = new Set();
    }

    public function identifier(): Identifier
    {
        return $this->identifier;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function countTasks(): int
    {
        return $this->tasks->count();
    }

    public function addTask(Task $task): void
    {
        $this->tasks->add($task);
    }
}
