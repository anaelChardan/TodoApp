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

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class Identifier
{
    protected UuidInterface $uuid;
    protected const ERROR_ON_INSTANTIATION = '';

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function fromUuidString(string $uuid)
    {
        try {
            return new static(Uuid::fromString($uuid));
        } catch (\InvalidArgumentException $exception) {
            throw new \InvalidArgumentException(
                static::ERROR_ON_INSTANTIATION,
                $exception->getCode(),
                $exception
            );
        }
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(Identifier $identifier): bool
    {
        return $identifier->uuid->equals($this->uuid);
    }
}
