<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\UserInterface\Http;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Todo\ShareSpace\Tool\MessageBus\QueryBus;
use Todo\Todo\Application\Read\CountTaskOfTodoList\CountTaskOfTodoList;

final class CountTaskForTodoList
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @ParamConverter("countTaskOfTodoList", class="Todo\Todo\Application\Read\CountTaskOfTodoList\CountTaskOfTodoList")
     */
    public function __invoke(CountTaskOfTodoList $countTaskOfTodoList): JsonResponse
    {
        $result = (int) $this->queryBus->fetch($countTaskOfTodoList);

        return new JsonResponse(['todo_list_tasks_count' => $result]);
    }
}
