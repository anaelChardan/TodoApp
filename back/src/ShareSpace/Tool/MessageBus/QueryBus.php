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

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Todo\ShareSpace\Application\DomainDrivenDesign\Query;

/**
 * Not final for testing purpose
 * Adapt Symfony Messenger because dispatch returns an Envelope marked as final.
 */
class QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @final
     *
     * @return mixed
     */
    public function fetch(Query $query)
    {
        return $this->handle($query);
    }
}
