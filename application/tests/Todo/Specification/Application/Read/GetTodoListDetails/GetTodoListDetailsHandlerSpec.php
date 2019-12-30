<?php

namespace Specification\Todo\Todo\Application\Read\GetTodoListDetails;

use PhpSpec\ObjectBehavior;
use Todo\ShareSpace\Application\DomainDrivenDesign\QueryHandler;
use Todo\Tests\Todo\Set\Domain\TodoList\IdentifierSet;
use Todo\Todo\Domain\TodoList\Read\GetTodoListDetails;
use Todo\Todo\Application\Read\GetTodoListDetails\GetTodoListDetails as Query;
use Todo\Todo\Application\Read\GetTodoListDetails\GetTodoListDetailsHandler;
use Todo\Todo\Domain\TodoList\Read\Task;
use Todo\Todo\Domain\TodoList\Read\TodoList;

class GetTodoListDetailsHandlerSpec extends ObjectBehavior
{
    function let(GetTodoListDetails $getTodoListDetails)
    {
        $this->beConstructedWith($getTodoListDetails);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetTodoListDetailsHandler::class);
    }

    function it_is_a_query_handler()
    {
        $this->shouldBeAnInstanceOf(QueryHandler::class);
    }

    function it_returns_the_result_of_the_query_object(GetTodoListDetails $getTodoListDetails)
    {
        $query = new Query();
        $query->identifier = IdentifierSet::one()->__toString();

        $todoList = new TodoList(
            $query->identifier,
            'a_name',
            1,
            [new Task('a_task_uuid', 'a_task')]
        );
        $getTodoListDetails->__invoke((string) $query->identifier)->willReturn($todoList);

        $this->__invoke($query)->shouldReturn($todoList);
    }
}
