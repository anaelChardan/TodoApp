<?php

namespace Specification\Todo\Todo\Application\Read\CountTaskOfTodoList;

use PhpSpec\ObjectBehavior;
use Todo\ShareSpace\Application\DomainDrivenDesign\Query;
use Todo\Tests\Todo\Set\Domain\TodoList\NameSet;
use Todo\Todo\Application\Read\CountTaskOfTodoList\CountTaskOfTodoList;

class CountTaskOfTodoListSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CountTaskOfTodoList::class);
    }

    function it_is_a_query()
    {
        $this->shouldBeAnInstanceOf(Query::class);
    }

    function it_has_a_todo_list_identifier()
    {
        $this->todoListName = NameSet::one()->__toString();
    }
}
