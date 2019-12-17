<?php

namespace Specification\Todo\Todo\Application\Write\AddTaskToTodoList;

use PhpSpec\ObjectBehavior;
use Todo\ShareSpace\Application\DomainDrivenDesign\CommandHandler;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\IdentifierSet as TaskIdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\NameSet;
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Application\Write\AddTaskToTodoList\AddTaskToTodoList;
use Todo\Todo\Application\Write\AddTaskToTodoList\AddTaskToTodoListHandler;
use Todo\Todo\Domain\TodoList\Write\Identifier;
use Todo\Todo\Domain\TodoList\Write\Repository;
use Todo\Todo\Domain\TodoList\Write\Task\Identifier as TaskIdentifier;
use Todo\Todo\Domain\TodoList\Write\Task\Name;
use Todo\Todo\Domain\TodoList\Write\Task\Task;

class AddTaskToTodoListHandlerSpec extends ObjectBehavior
{
    function let(Repository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddTaskToTodoListHandler::class);
    }

    function it_is_a_command_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_adds_a_task_to_the_todo(Repository $repository)
    {
        $todoList = TodoListSet::one();
        $command = new AddTaskToTodoList();
        $command->identifier = TaskIdentifierSet::one()->__toString();
        $command->todoListIdentifier = $todoList->identifier()->__toString();
        $command->name = NameSet::one()->__toString();

        $repository->get(Identifier::fromUuidString($command->todoListIdentifier))->willReturn($todoList);
        $task = new Task(TaskIdentifier::fromUuidString($command->identifier), Name::fromString($command->name));
        $todoList->addTask($task);
        $repository->save($todoList)->shouldBeCalled();

        $this->__invoke($command);
    }
}
