<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Read;

interface GetTodoListDetails
{
    public function __invoke(string $identifier): TodoList;
}
