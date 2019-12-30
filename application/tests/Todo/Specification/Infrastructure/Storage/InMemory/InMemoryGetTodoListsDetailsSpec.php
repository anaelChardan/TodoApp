<?php

namespace Specification\Todo\Todo\Infrastructure\Storage\InMemory;

use PhpSpec\ObjectBehavior;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\TaskSet;
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Domain\TodoList\Read\GetTodoListsDetails;
use Todo\Todo\Domain\TodoList\Read\TodoList;
use Todo\Todo\Domain\TodoList\Read\TodoLists;
use Todo\Todo\Infrastructure\Storage\InMemory\InMemoryGetTodoListsDetails;
use Todo\Todo\Infrastructure\Storage\InMemory\Store;

class InMemoryGetTodoListsDetailsSpec extends ObjectBehavior
{
    function let()
    {
        $store = new Store();
        $this->beConstructedWith($store);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryGetTodoListsDetails::class);
    }

    function it_is_a_query_count()
    {
        $this->shouldBeAnInstanceOf(GetTodoListsDetails::class);
    }

    function it_works()
    {
        $store = new Store();
        $todoList = TodoListSet::one();
        $task = TaskSet::one($todoList);
        $todoList->addTask($task);
        $store->set((string) $todoList->identifier(), $todoList);

        $todoListTwo = TodoListSet::one();
        $taskTwo = TaskSet::one($todoListTwo);
        $taskThree = TaskSet::one($todoListTwo);
        $todoListTwo->addTask($taskTwo);
        $todoListTwo->addTask($taskThree);
        $store->set($todoListTwo->identifier()->__toString(), $todoListTwo);

        $todoListReadModel = new TodoList(
            $todoList->identifier()->__toString(),
            $todoList->name()->__toString(),
            1,
            [$task]
        );

        $todoListTwoReadModel = new TodoList(
            $todoListTwo->identifier()->__toString(),
            $todoListTwo->name()->__toString(),
            2,
            [$taskTwo, $taskThree]
        );

        $todoListsReadModel = new TodoLists([$todoListReadModel, $todoListTwoReadModel]);


        $this->beConstructedWith($store);
        $this->__invoke($todoList->identifier()->__toString())->shouldBeLike($todoListsReadModel);
    }
}
