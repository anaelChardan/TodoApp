<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\Set\Domain\TodoList;

use Innmind\BlackBox\Set;
use Innmind\BlackBox\Set\Composite;
use Todo\Todo\Domain\TodoList\Write\Identifier;
use Todo\Todo\Domain\TodoList\Write\Name;
use Todo\Todo\Domain\TodoList\Write\TodoList;

final class TodoListSet
{
    public static function one(): TodoList
    {
        return static::any()->take(1)->values()->current();
    }

    public static function any(): Set
    {
        return Composite::of(
            fn (Identifier $identifier, Name $name): TodoList => new TodoList($identifier, $name),
            IdentifierSet::any(),
            NameSet::any()
        );
    }
}
