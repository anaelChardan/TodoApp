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
use Ramsey\Uuid\UuidInterface;
use Todo\Tests\Todo\Set\Other\UuidSet;
use Todo\Todo\Domain\TodoList\Write\Identifier;

final class IdentifierSet
{
    public static function one(): Identifier
    {
        return static::any()->take(1)->values()->current();
    }

    public static function any(): Set
    {
        return Decorate::of(
            fn (UuidInterface $uuid): Identifier => new Identifier($uuid),
            UuidSet::any()
        );
    }
}
