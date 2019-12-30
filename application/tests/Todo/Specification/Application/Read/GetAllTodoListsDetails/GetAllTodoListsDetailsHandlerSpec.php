<?php

namespace Specification\Todo\Todo\Application\Read\CountTaskOfTodoList;

use PhpSpec\ObjectBehavior;
use Todo\ShareSpace\Application\DomainDrivenDesign\QueryHandler;
use Todo\Todo\Domain\TodoList\Read\GetTodoListsDetails;
use Todo\Todo\Application\Read\GetAllTodoListsDetails\GetAllTodoListsDetails as Query;
use Todo\Todo\Application\Read\GetAllTodoListsDetails\GetAllTodoListsDetailsHandler;
use Todo\Todo\Domain\TodoList\Read\Task;
use Todo\Todo\Domain\TodoList\Read\TodoList;

class GetAllTodoListsDetailsHandlerSpec extends ObjectBehavior
{
    function let(GetTodoListsDetails $getTodoListDetails)
    {
        $this->beConstructedWith($getTodoListDetails);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetAllTodoListsDetailsHandler::class);
    }

    function it_is_a_query_handler()
    {
        $this->shouldBeAnInstanceOf(QueryHandler::class);
    }

    function it_returns_the_result_of_the_query_object(GetTodoListsDetails $getTodoListsDetails)
    {
        $query = new Query();
        $todoLists = [];
        $todoLists[] = new TodoList(
            'an_identifier',
            'a_name',
            1,
            [new Task('a_task_uuid', 'a_task')]
        );
        $todoLists[] = new TodoList(
            'a_super_identifier',
            'a_super_name',
            2,
            [new Task('a_task_uuid_top', 'a_task_top'), new Task('another', 'one')]
        );
        $getTodoListsDetails->__invoke()->willReturn($todoLists);

        $this->__invoke($query)->shouldReturn($todoLists);
    }
}
