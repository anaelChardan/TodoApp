<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Application\Write\AddTaskToTodoList;

use Todo\ShareSpace\Application\DomainDrivenDesign\CommandHandler;
use Todo\Todo\Domain\TodoList\Write\Identifier;
use Todo\Todo\Domain\TodoList\Write\Repository;
use Todo\Todo\Domain\TodoList\Write\Task\Identifier as TaskIdentifier;
use Todo\Todo\Domain\TodoList\Write\Task\Name;
use Todo\Todo\Domain\TodoList\Write\Task\Task;

class AddTaskToTodoListHandler implements CommandHandler
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddTaskToTodoList $addTaskToTodoList): void
    {
        $todoList = $this->repository->get(Identifier::fromUuidString((string) $addTaskToTodoList->todoListIdentifier));
        $task = new Task(
            TaskIdentifier::fromUuidString((string) $addTaskToTodoList->identifier),
            Name::fromString((string) $addTaskToTodoList->name)
        );

        $todoList->addTask($task);
        $this->repository->save($todoList);
    }
}
