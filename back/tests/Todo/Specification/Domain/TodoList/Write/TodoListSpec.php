<?php

namespace Specification\Todo\Todo\Domain\TodoList\Write;

use Doctrine\Common\Collections\ArrayCollection;
use Innmind\BlackBox\PHPUnit\BlackBox;
use PhpSpec\ObjectBehavior;
use Todo\Tests\Todo\Set\Domain\TodoList\IdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\IdentifierSet as TaskIdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\NameSet as TaskNameSet;
use Todo\Tests\Todo\Set\Domain\TodoList\NameSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\TaskSet;
use Todo\Todo\Domain\TodoList\Write\Task\Task;
use Todo\Todo\Domain\TodoList\Write\TodoList;

class TodoListSpec extends ObjectBehavior
{
    use BlackBox;

    public function let()
    {
        $this->beConstructedWith(IdentifierSet::one(), NameSet::one());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TodoList::class);
    }

    function it_is_possible_to_add_a_task()
    {
        $tasks = new ArrayCollection([]);

        $this
            ->forAll(TaskSet::any())
            ->then(function (Task $task) use (&$tasks) {
                $this->addTask($task);
                $task->ofTodoList($this->getWrappedObject());
                $tasks->set((string) $task->identifier(), $task);
                $this->tasks()->shouldBeLike($tasks);
            });
    }
}
