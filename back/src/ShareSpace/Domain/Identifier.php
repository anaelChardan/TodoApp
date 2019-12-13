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
    /** @var UuidInterface */
    protected $uuid;

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
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
