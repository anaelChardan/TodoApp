<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\UserInterface\Http\TodoList\Write;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use Todo\ShareSpace\Tool\MessageBus\CommandBus;
use Todo\Todo\Application\Write\AddTaskToTodoList\AddTaskToTodoList;

final class AddTaskForTodoList
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @ParamConverter("addTaskToTodoList", class="Todo\Todo\Application\Write\AddTaskToTodoList\AddTaskToTodoList")
     */
    public function __invoke(string $identifier, AddTaskToTodoList $addTaskToTodoList): JsonResponse
    {
        $addTaskToTodoList->todoListIdentifier = $identifier;
        $result = $this->commandBus->dispatch($addTaskToTodoList);

        return new JsonResponse(['task_identifier' => $result->toString()], Response::HTTP_ACCEPTED);
    }
}
