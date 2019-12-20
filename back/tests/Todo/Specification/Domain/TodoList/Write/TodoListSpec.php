<?php

namespace Specification\Todo\Todo\Domain\TodoList\Write;

use Innmind\BlackBox\PHPUnit\BlackBox;
use PhpSpec\ObjectBehavior;
use Todo\Tests\Todo\Set\Domain\TodoList\IdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\IdentifierSet as TaskIdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\NameSet as TaskNameSet;
use Todo\Tests\Todo\Set\Domain\TodoList\NameSet;
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
            ->forAll(TaskIdentifierSet::any(), TaskNameSet::any())
            ->then(function ($identifier, $name) use (&$numberOfTasks) {
                $numberOfTasks++;
                $this->addTask(TaskIdentifierSet::one(), TaskNameSet::one());
                $this->countTasks()->shouldReturn($numberOfTasks);
            });
    }
}
