<?php

/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Write\Event;

use ConvenientImmutability\Immutable;
use Todo\ShareSpace\Application\DomainDrivenDesign\Entity\DomainEvent;

final class TaskAdded implements DomainEvent
{
    use Immutable;

    public string $todoListIdentifier;
    public string $taskIdentifier;

    public function __construct(string $todoListIdentifier, string $taskIdentifier)
    {
        $this->todoListIdentifier = $todoListIdentifier;
        $this->taskIdentifier = $taskIdentifier;
    }
}
