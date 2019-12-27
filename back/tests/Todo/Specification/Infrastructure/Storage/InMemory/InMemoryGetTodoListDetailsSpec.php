<?php

namespace Specification\Todo\Todo\Infrastructure\Storage\InMemory;

use PhpSpec\ObjectBehavior;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\IdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\NameSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\TaskSet;
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Domain\TodoList\Read\GetTodoListDetails;
use Todo\Todo\Domain\TodoList\Read\Task;
use Todo\Todo\Domain\TodoList\Read\TodoList;
use Todo\Todo\Infrastructure\Storage\InMemory\InMemoryGetTodoListDetails;
use Todo\Todo\Infrastructure\Storage\InMemory\Store;

class InMemoryGetTodoListDetailsSpec extends ObjectBehavior
{
    function let()
    {
        $store = new Store();
        $this->beConstructedWith($store);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryGetTodoListDetails::class);
    }

    function it_is_a_query_count()
    {
        $this->shouldBeAnInstanceOf(GetTodoListDetails::class);
    }

    function it_works_for_a_todo_list_identifier()
    {
        $store = new Store();
        $todoList = TodoListSet::one();
        $task = TaskSet::one($todoList);
        $todoList->addTask($task);
        $store->set((string) $todoList->identifier(), $todoList);

        $todoListReadModel = new TodoList(
            (string) $todoList->identifier(),
            (string) $todoList->name(),
            1,
            [$task]
        );

        $this->beConstructedWith($store);
        $this->__invoke((string) $todoList->identifier())->shouldBeLike($todoListReadModel);
    }
}
