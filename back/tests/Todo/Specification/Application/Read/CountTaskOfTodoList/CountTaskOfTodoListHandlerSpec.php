<?php

namespace Specification\Todo\Todo\Application\Read\CountTaskOfTodoList;

use PhpSpec\ObjectBehavior;
use Todo\ShareSpace\Application\DomainDrivenDesign\QueryHandler;
use Todo\Tests\Todo\Set\Domain\TodoList\IdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\NameSet;
use Todo\Todo\Application\Read\CountTaskOfTodoList\CountTaskOfTodoList;
use Todo\Todo\Application\Read\CountTaskOfTodoList\CountTaskOfTodoListHandler;
use Todo\Todo\Domain\TodoList\Read\CountTaskForTodoList;

class CountTaskOfTodoListHandlerSpec extends ObjectBehavior
{
    function let(CountTaskForTodoList $countTaskForTodoList)
    {
        $this->beConstructedWith($countTaskForTodoList);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CountTaskOfTodoListHandler::class);
    }

    function it_is_a_query_handler()
    {
        $this->shouldBeAnInstanceOf(QueryHandler::class);
    }

    function it_returns_the_result_of_the_query_object(CountTaskForTodoList $countTaskForTodoList)
    {
        $query = new CountTaskOfTodoList();
        $query->todoListName = NameSet::one()->__toString();
        $countTaskForTodoList->__invoke((string) $query->todoListName)->willReturn(12);
        $this->__invoke($query)->shouldReturn(12);
    }
}
