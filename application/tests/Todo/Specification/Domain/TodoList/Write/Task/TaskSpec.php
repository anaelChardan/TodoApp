<?php

namespace Specification\Todo\Todo\Domain\TodoList\Write\Task;

use PhpSpec\ObjectBehavior;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\IdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\NameSet;
use Todo\Todo\Domain\TodoList\Write\Task\Task;

class TaskSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(IdentifierSet::one(), NameSet::one());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Task::class);
    }
}
