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
use Todo\Todo\Domain\TodoList\Read\GetTodoListsDetails;
use Todo\Todo\Domain\TodoList\Write;

final class InMemoryGetTodoListsDetails implements GetTodoListsDetails
{
    private Store $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function __invoke(): Read\TodoLists
    {
        /** @var array<Read\TodoList> $values */
        $values = $this
            ->store
            ->all()
            ->map(
                fn (string $key, Write\TodoList $todoList) => new Read\TodoList(
                    $todoList->identifier()->__toString(),
                    $todoList->name()->__toString(),
                    $todoList->tasks()->count(),
                    array_map(
                        fn (Write\Task\Task $task) => new Read\Task((string) $task->identifier(), (string) $task->name()),
                        $todoList->tasks()->toArray()
                    )
                )
            )
            ->values()
            ->toArray();

        return new Read\TodoLists($values);
    }
}
