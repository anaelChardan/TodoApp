<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\UserInterface\Http\TodoList\Read;

use Symfony\Component\HttpFoundation\JsonResponse;
use Todo\ShareSpace\Tool\MessageBus\QueryBus;
use Todo\Todo\Application\Read\GetTodoListDetails\GetTodoListDetails as Query;
use Todo\Todo\Domain\TodoList\Read\TodoList;

final class GetTodoListDetails
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(string $identifier): JsonResponse
    {
        $query = new Query();
        $query->identifier = $identifier;

        /** @var TodoList $result */
        $result = $this->queryBus->fetch($query);

        return new JsonResponse($result->normalize());
    }
}
