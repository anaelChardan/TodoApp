<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Write;

interface Repository
{
    public function save(TodoList $todoList): void;

    public function get(Identifier $identifier): TodoList;
}
