<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Application\Read\CountTaskOfTodoList;

use Todo\ShareSpace\Application\DomainDrivenDesign\QueryHandler;
use Todo\Todo\Domain\TodoList\Read\CountTaskForTodoList;

final class CountTaskOfTodoListHandler implements QueryHandler
{
    private CountTaskForTodoList $countTaskForTodoList;

    public function __construct(CountTaskForTodoList $countTaskForTodoList)
    {
        $this->countTaskForTodoList = $countTaskForTodoList;
    }

    public function __invoke(CountTaskOfTodoList $countTaskOfTodoList): int
    {
        return ($this->countTaskForTodoList)((string) $countTaskOfTodoList->todoListName);
    }
}
