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
use Todo\Todo\Application\Read\GetAllTodoListsDetails\GetAllTodoListsDetails as Query;

final class GetAllTodoListsDetails
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(): JsonResponse
    {
        $result = $this->queryBus->fetch(new Query());

        return new JsonResponse($result->normalize());
    }
}
