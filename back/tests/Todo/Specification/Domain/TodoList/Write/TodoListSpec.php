<?php

namespace Specification\Todo\Todo\Domain\TodoList\Write;

use Innmind\BlackBox\PHPUnit\BlackBox;
use PhpSpec\ObjectBehavior;
use Todo\Tests\Todo\Set\Domain\TodoList\IdentifierSet;
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
        $numberOfTasks = 0;

        $this
            ->forAll(TaskSet::any())
            ->then(function (Task $task) use (&$numberOfTasks) {
                $numberOfTasks++;
                $this->addTask($task);
                $this->countTasks()->shouldReturn($numberOfTasks);
            });
    }
}
