<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Tool\MessageBus;

use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Todo\ShareSpace\Application\DomainDrivenDesign\Command;
use Todo\ShareSpace\Tool\MessageBus\Command\IdentifierGeneratedStamp;

/**
 * Not final for testing purpose
 * Adapt Symfony Messenger because dispatch returns an Envelope marked as final.
 */
class CommandBus
{
    /** @var MessageBusInterface */
    private $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @final
     */
    public function dispatch(Command $command): UuidInterface
    {
        $envelope = $this->commandBus->dispatch($command);
        /** @var IdentifierGeneratedStamp|null $stamp */
        $stamp = $envelope->last(IdentifierGeneratedStamp::class);
        if (null !== $stamp) {
            return $stamp->uuid();
        }

        throw new \LogicException('Should have generated the identifier');
    }
}
