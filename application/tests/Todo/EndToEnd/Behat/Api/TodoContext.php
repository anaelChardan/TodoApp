<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\EndToEnd\Behat\Api;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Response;
use Todo\Tests\Behat\ApiTestHelper;
use Todo\Todo\Domain\TodoList\Write\Repository;
use Webmozart\Assert\Assert;

final class TodoContext implements Context
{
    private ApiTestHelper $apiTestHelper;
    private Repository $repository;
    private array $todoLists = [];

    public function __construct(ApiTestHelper $apiTestHelper, Repository $repository)
    {
        $this->apiTestHelper = $apiTestHelper;
        $this->repository = $repository;
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
        $content = ['name' => $todoListName];

        $response = $this->apiTestHelper->jsonPost($content, 'create_todo_list');
        $identifier = \Safe\json_decode($response->getContent(), true)['todo_list_identifier'];

        $this->todoLists[$todoListName] = $identifier;

        Assert::eq($response->getStatusCode(), Response::HTTP_ACCEPTED);
    }

    /**
     * @Then :todoListName should have :numberOfTasks task(s)
     */
    public function shouldHaveTask(string $todoListName, int $numberOfTasks)
    {
        $response = $this->apiTestHelper->jsonGet([], 'get_todo_list_details', ['identifier' => $this->todoLists[$todoListName]]);

        Assert::eq(\Safe\json_decode($response->getContent(), true)['task_count'], $numberOfTasks);
    }

    /**
     * @When I add a task named :taskName to the list :todoListName
     */
    public function iAddATaskNamedToTheList(string $taskName, string $todoListName)
    {
        $content = ['name' => $taskName];

        $response = $this->apiTestHelper->jsonPost($content, 'add_task_to_todo_list', ['identifier' => $this->todoLists[$todoListName]]);

        Assert::eq($response->getStatusCode(), Response::HTTP_ACCEPTED);
    }
}
