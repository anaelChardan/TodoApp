<?php

namespace Specification\Todo\Todo\Infrastructure\Storage\TodoList;

use PhpSpec\ObjectBehavior;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\TaskSet;
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Domain\TodoList\Read\CountTaskForTodoList;
use Todo\Todo\Infrastructure\Storage\TodoList\InMemoryCountTaskForTodoList;
use Todo\Todo\Infrastructure\Storage\TodoList\Store;

class InMemoryCountTaskForTodoListSpec extends ObjectBehavior
{
    function let()
    {
        $store = new Store();
        $this->beConstructedWith($store);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryCountTaskForTodoList::class);
    }

    function it_is_a_query_count()
    {
        $this->shouldBeAnInstanceOf(CountTaskForTodoList::class);
    }

    function it_counts_for_a_todo_list_name()
    {
        $store = new Store();
        $todoList = TodoListSet::one();
        $task = TaskSet::one();
        $todoList->addTask($task);
        $store->set($todoList->identifier()->__toString(), $todoList);
        $this->beConstructedWith($store);
        $this->__invoke($todoList->name()->__toString())->shouldReturn(1);
    }
}
