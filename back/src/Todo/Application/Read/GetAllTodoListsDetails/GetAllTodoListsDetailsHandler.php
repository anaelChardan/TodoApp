<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Application\Read\GetAllTodoListsDetails;

use Todo\ShareSpace\Application\DomainDrivenDesign\QueryHandler;
use Todo\ShareSpace\Domain\Read\ReadModel;
use Todo\Todo\Domain\TodoList\Read\GetTodoListsDetails as GetAllTodoListsQuery;

final class GetAllTodoListsDetailsHandler implements QueryHandler
{
    private GetAllTodoListsQuery $getAllTodoListsQuery;

    public function __construct(GetAllTodoListsQuery $getAllTodoLists)
    {
        $this->getAllTodoListsQuery = $getAllTodoLists;
    }

    public function __invoke(GetAllTodoListsDetails $getAllTodoLists): ReadModel
    {
        return ($this->getAllTodoListsQuery)();
    }
}
