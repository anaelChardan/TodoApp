<?php

/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

declare(strict_types=1);

namespace Todo\ShareSpace\Application\DomainDrivenDesign\Entity;

trait DomainEventsRecorderCapabilities
{
    /** @var DomainEvent[] */
    private array $domainEvents = [];

    protected function record(DomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function popEvents(): array
    {
        $events = $this->domainEvents;

        $this->domainEvents = [];

        return $events;
    }
}
