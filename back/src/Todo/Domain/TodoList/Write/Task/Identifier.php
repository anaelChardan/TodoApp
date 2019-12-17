<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Domain\TodoList\Write\Task;

use Ramsey\Uuid\Uuid;
use Todo\ShareSpace\Domain\Identifier as AbstractIdentifier;

final class Identifier extends AbstractIdentifier
{
    public static function fromUuidString(string $uuid): Identifier
    {
        $uuidObject = Uuid::fromString($uuid);

        return new self($uuidObject);
    }
}
