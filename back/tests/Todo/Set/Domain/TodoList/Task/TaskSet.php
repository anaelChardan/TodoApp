<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\Set\Domain\TodoList\Task;

use Innmind\BlackBox\Set;
use Innmind\BlackBox\Set\Composite;
use Todo\Todo\Domain\TodoList\Write\Task\Identifier;
use Todo\Todo\Domain\TodoList\Write\Task\Name;
use Todo\Todo\Domain\TodoList\Write\Task\Task;
use Todo\Todo\Domain\TodoList\Write\TodoList;

final class TaskSet
{
    public static function one(TodoList $todoList): Task
    {
        return static::any($todoList)->take(1)->values()->current();
    }

    public static function any(TodoList $todoList): Set
    {
        return Composite::of(
            fn (Identifier $identifier, Name $name): Task => new Task($identifier, $name, $todoList),
            IdentifierSet::any(),
            NameSet::any()
        );
    }
}
