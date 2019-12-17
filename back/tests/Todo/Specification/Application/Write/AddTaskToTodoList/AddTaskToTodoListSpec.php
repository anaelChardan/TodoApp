<?php

namespace Specification\Todo\Todo\Application\Write\AddTaskToTodoList;

use PhpSpec\ObjectBehavior;
use Todo\ShareSpace\Application\DomainDrivenDesign\Command;
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Application\Write\AddTaskToTodoList\AddTaskToTodoList;

class AddTaskToTodoListSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AddTaskToTodoList::class);
    }

    function it_is_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_as_a_todo_list_identifier()
    {
        $this->todoListIdentifier = TodoListSet::one()->identifier()->__toString();
    }
}
