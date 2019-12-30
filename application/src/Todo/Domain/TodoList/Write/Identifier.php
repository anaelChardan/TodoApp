<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Domain\TodoList\Write;

use Ramsey\Uuid\Uuid;
use Todo\ShareSpace\Domain\Identifier as AbstractIdentifier;

final class Identifier extends AbstractIdentifier
{
    public static function fromUuidString(string $uuid): Identifier
    {
        try {
            return new Identifier(Uuid::fromString($uuid));
        } catch (\InvalidArgumentException $exception) {
            throw new \InvalidArgumentException('Expected a valid uuid for '.static::class, (int) $exception->getCode(), $exception);
        }
    }
}
