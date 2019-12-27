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
use Todo\ShareSpace\Tool\MessageBus\CommandBus;
use Todo\Todo\Application\Write\AddTodoList\AddTodoList;

final class CreateTodoList
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @ParamConverter("addTodoList", class="Todo\Todo\Application\Write\AddTodoList\AddTodoList")
     */
    public function __invoke(AddTodoList $addTodoList): JsonResponse
    {
        $command = $this->commandBus->dispatch($addTodoList);

        return new JsonResponse(['todo_list_identifier' => $command->toString()], Response::HTTP_ACCEPTED);
    }
}
