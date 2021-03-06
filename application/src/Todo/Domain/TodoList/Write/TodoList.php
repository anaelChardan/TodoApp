<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Domain\TodoList\Write;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @psalm-suppress TooManyTemplateParams
 */
class TodoList
{
    private Identifier $identifier;
    private Name $name;

    /** @var Collection<string, Task\Task> */
    private Collection $tasks;

    /**
     * @psalm-suppress MixedPropertyTypeCoercion
     */
    public function __construct(Identifier $identifier, Name $name)
    {
        $this->identifier = $identifier;
        $this->name = $name;
        $this->tasks = new ArrayCollection();
    }

    public function identifier(): Identifier
    {
        return $this->identifier;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function addTask(Task\Task $task): void
    {
        $task->ofTodoList($this);
        $this->tasks->set((string) $task->identifier(), $task);
    }

    /**
     * @return Collection<string, Task\Task>
     */
    public function tasks(): Collection
    {
        return $this->tasks;
    }
}
