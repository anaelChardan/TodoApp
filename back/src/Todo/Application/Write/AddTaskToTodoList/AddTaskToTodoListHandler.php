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

        $todoList->addTask(
            TaskIdentifier::fromUuidString((string) $addTaskToTodoList->identifier),
            Name::fromString((string) $addTaskToTodoList->name)
        );

        $this->repository->save($todoList);
    }
}
