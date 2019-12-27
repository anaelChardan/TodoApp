<?php

namespace Specification\Todo\Todo\Application\Read\GetTodoListDetails;

use PhpSpec\ObjectBehavior;
use Todo\ShareSpace\Application\DomainDrivenDesign\Query;
use Todo\Tests\Todo\Set\Domain\TodoList\IdentifierSet;
use Todo\Todo\Application\Read\GetTodoListDetails\GetTodoListDetails;

class GetTodoListDetailsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GetTodoListDetails::class);
    }

    function it_is_a_query()
    {
        $this->shouldBeAnInstanceOf(Query::class);
    }

    function it_has_a_todo_list_identifier()
    {
        $this->identifier = IdentifierSet::one()->__toString();
    }
}
