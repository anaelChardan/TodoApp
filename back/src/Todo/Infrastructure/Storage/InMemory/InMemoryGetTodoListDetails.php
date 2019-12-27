<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\Storage\InMemory;

use Todo\Todo\Domain\TodoList\Read;
use Todo\Todo\Domain\TodoList\Read\GetTodoListDetails;
use Todo\Todo\Domain\TodoList\Read\TodoList;
use Todo\Todo\Domain\TodoList\Write;

final class InMemoryGetTodoListDetails implements GetTodoListDetails
{
    private Store $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function __invoke(string $identifier): TodoList
    {
        /** @var Write\TodoList $todoList */
        $todoList = $this->store->get($identifier);

        return new TodoList(
            (string) $todoList->identifier(),
            (string) $todoList->name(),
            $todoList->tasks()->count(),
            array_map(
                fn (Write\Task\Task $task) => new Read\Task((string) $task->identifier(), (string) $task->name()),
                $todoList->tasks()->toArray()
            )
        );
    }
}
