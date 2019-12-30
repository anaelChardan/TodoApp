<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\Acceptance\Behat;

use Behat\Behat\Context\Context;
use Todo\ShareSpace\Tool\MessageBus\CommandBus;
use Todo\ShareSpace\Tool\MessageBus\QueryBus;
use Todo\Todo\Application\Read\GetTodoList\CountTaskOfTodoList;
use Todo\Todo\Application\Read\GetTodoListDetails\GetTodoListDetails;
use Todo\Todo\Application\Write\AddTaskToTodoList\AddTaskToTodoList;
use Todo\Todo\Application\Write\AddTodoList\AddTodoList;
use Todo\Todo\Domain\TodoList\Read\TodoList;
use Webmozart\Assert\Assert;

final class TodoContext implements Context
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    private array $todoLists = [];

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @Given I'm connected as :username
     */
    public function imConnectedAs(string $username): bool
    {
        return true;
    }

    /**
     * @Given a todo list named :todoListName
     * @When I create a todo list named :todoListName
     */
    public function iCreateATodoListNamed(string $todoListName)
    {
        $command = new AddTodoList();
        $command->name = $todoListName;

        $todoListId = $this->commandBus->dispatch($command);

        $this->todoLists[$todoListName] = $todoListId;
    }

    /**
     * @When I add a task named :taskName to the list :todoListName
     */
    public function iAddATaskNamedToTheList(string $taskName, string $todoListName)
    {
        $command = new AddTaskToTodoList();
        $command->name = $taskName;
        $command->todoListIdentifier = $this->todoLists[$todoListName];

        $this->commandBus->dispatch($command);
    }

    /**
     * @Then :todoListName should have :numberOfTasks task(s)
     */
    public function shouldHaveTask(string $todoListName, int $numberOfTasks)
    {
        $query = new GetTodoListDetails();
        $query->identifier = $this->todoLists[$todoListName];

        /** @var TodoList $result */
        $result = $this->queryBus->fetch($query);
        Assert::eq($result->normalize()['task_count'], $numberOfTasks);
    }
}
