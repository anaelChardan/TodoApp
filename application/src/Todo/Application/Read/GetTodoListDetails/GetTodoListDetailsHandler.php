<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Application\Read\GetTodoListDetails;

use Todo\ShareSpace\Application\DomainDrivenDesign\QueryHandler;
use Todo\Todo\Domain\TodoList\Read\GetTodoListDetails as GetTodoListDetailsQuery;
use Todo\Todo\Domain\TodoList\Read\TodoList;

final class GetTodoListDetailsHandler implements QueryHandler
{
    private GetTodoListDetailsQuery $getAllTodoListsQuery;

    public function __construct(GetTodoListDetailsQuery $getAllTodoLists)
    {
        $this->getAllTodoListsQuery = $getAllTodoLists;
    }

    public function __invoke(GetTodoListDetails $getTodoListDetails): TodoList
    {
        return ($this->getAllTodoListsQuery)((string) $getTodoListDetails->identifier);
    }
}
