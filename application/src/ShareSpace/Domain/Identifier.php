<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Domain;

use Ramsey\Uuid\UuidInterface;

abstract class Identifier
{
    protected UuidInterface $uuid;

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    abstract public static function fromUuidString(string $uuid): Identifier;

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(Identifier $identifier): bool
    {
        return $identifier->uuid->equals($this->uuid);
    }
}
