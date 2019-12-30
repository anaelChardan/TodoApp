<?php

namespace Specification\Todo\Todo\Application\Write\AddTodoList;

use Todo\Todo\Domain\TodoList\Write\Repository;
use PhpSpec\ObjectBehavior;
use Todo\ShareSpace\Application\DomainDrivenDesign\CommandHandler;
use Todo\Tests\Todo\Set\Domain\TodoList\IdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\NameSet;
use Todo\Todo\Application\Write\AddTodoList\AddTodoList;
use Todo\Todo\Application\Write\AddTodoList\AddTodoListHandler;
use Todo\Todo\Domain\TodoList\Write\Identifier;
use Todo\Todo\Domain\TodoList\Write\Name;
use Todo\Todo\Domain\TodoList\Write\TodoList;

class AddTodoListHandlerSpec extends ObjectBehavior
{
    function let(Repository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddTodoListHandler::class);
    }

    function it_is_an_handler()
    {
        $this->shouldBeAnInstanceOf(CommandHandler::class);
    }

    function it_saves_a_todo_list(Repository $repository)
    {
        $addTodoList = new AddTodoList();
        $addTodoList->identifier = IdentifierSet::one()->__toString();
        $addTodoList->name = NameSet::one()->__toString();

        $todoList = new TodoList(Identifier::fromUuidString($addTodoList->identifier), Name::fromString($addTodoList->name));
        $repository->save($todoList)->shouldBeCalled();

        $this->__invoke($addTodoList);
    }
}
