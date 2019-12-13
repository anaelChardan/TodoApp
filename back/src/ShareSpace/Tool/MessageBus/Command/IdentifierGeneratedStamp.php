<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Tool\MessageBus\Command;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;

final class IdentifierGeneratedStamp implements StampInterface
{
    /** @var UuidInterface */
    private $uuid;

    public function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }
}
