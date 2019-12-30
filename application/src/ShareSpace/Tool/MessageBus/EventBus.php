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

use Symfony\Component\Messenger\MessageBusInterface;
use Todo\ShareSpace\Application\DomainDrivenDesign\Event;

/**
 * Not final for testing purpose
 * Adapt Symfony Messenger because dispatch returns an Envelope marked as final.
 */
class EventBus
{
    /** @var MessageBusInterface */
    private $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @final
     */
    public function dispatch(Event $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
