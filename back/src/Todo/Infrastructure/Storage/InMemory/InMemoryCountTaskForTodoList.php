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

use Todo\Todo\Domain\TodoList\Read\CountTaskForTodoList;
use Todo\Todo\Domain\TodoList\Write\Name;
use Todo\Todo\Domain\TodoList\Write\TodoList;

final class InMemoryCountTaskForTodoList implements CountTaskForTodoList
{
    private Store $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function __invoke(string $todoListName): int
    {
        $todoLists = $this
            ->store
            ->all()
            ->values()
            ->filter(
                fn (TodoList $todoList) => $todoList->name()->equals(Name::fromString($todoListName))
            );

        // Might be better to throw an exception
        if (0 === $todoLists->count()) {
            return 0;
        }

        /** @var TodoList $todoList */
        $todoList = $todoLists->first();

        return $todoList->countTasks();
    }
}
