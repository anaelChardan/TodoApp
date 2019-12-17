<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\Set\Other;

use Innmind\BlackBox\Set;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UuidSet
{
    public static function one(): UuidInterface
    {
        return Uuid::uuid5(
            Uuid::NAMESPACE_DNS,
            Set\Strings::any()->take(1)->values()->current()
        );
    }

    public static function any(): Set
    {
        return Set\Decorate::of(
            static function (string $string): UuidInterface
            {
                return Uuid::uuid5(Uuid::NAMESPACE_DNS, $string);
            },
            Set\Strings::any()
        );
    }
}
