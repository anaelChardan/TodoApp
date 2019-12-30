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
use Innmind\BlackBox\Set\Decorate;
use Innmind\BlackBox\Set\Strings;
use Todo\Todo\Domain\TodoList\Write\Name;

final class NameSet
{
    public static function one(): Name
    {
        return static::any()->take(1)->values()->current();
    }

    public static function any(): Set
    {
        return Decorate::of(
            fn (string $string): Name =>  Name::fromString($string),
            new Strings
        );
    }
}
