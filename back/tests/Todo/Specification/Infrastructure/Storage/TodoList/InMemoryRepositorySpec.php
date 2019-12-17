<?php

namespace Specification\Todo\Todo\Infrastructure\Storage\TodoList;

use Innmind\BlackBox\PHPUnit\BlackBox;
use PhpSpec\ObjectBehavior;
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Domain\TodoList\Write\Repository;
use Todo\Todo\Domain\TodoList\Write\TodoList;
use Todo\Todo\Infrastructure\Storage\TodoList\InMemoryRepository;
use Todo\Todo\Infrastructure\Storage\TodoList\Store;

class InMemoryRepositorySpec extends ObjectBehavior
{
    use BlackBox;

    function let()
    {
        $this->beConstructedWith(new Store());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryRepository::class);
    }

    function it_is_a_repository()
    {
        $this->shouldBeAnInstanceOf(Repository::class);
    }

    function it_saves_a_todo_list()
    {
        $this
            ->forAll(TodoListSet::any())
            ->then(function (TodoList $todoList) {
                $this->save($todoList);
                $this->get($todoList->identifier())->shouldReturn($todoList);
            });
    }
}
