<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\EndToEnd\Behat\Front;

use Behat\Behat\Context\Context;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverElement;
use Symfony\Component\Panther\PantherTestCaseTrait;
use Todo\ShareSpace\Tool\MessageBus\CommandBus;
use Todo\Tests\Behat\BrowserHelper;
use Todo\Todo\Application\Write\AddTodoList\AddTodoList;
use Webmozart\Assert\Assert;

final class TodoContext implements Context
{
    use PantherTestCaseTrait;

    private BrowserHelper $browserHelper;
    private CommandBus $commandBus;

    public function __construct(BrowserHelper $browserHelper, CommandBus $commandBus)
    {
        $this->browserHelper = $browserHelper;
        $this->commandBus = $commandBus;
    }

    /**
     * @Given I'm connected as :username
     */
    public function iMConnectedAs(string $username): void
    {
        $this->browserHelper->request('GET', '');
    }

    /**
     * @Given a todo list named :todoListName
     */
    public function andATodoListNamed(string $todoListName): void
    {
        $command = new AddTodoList();
        $command->name = $todoListName;
        $this->commandBus->dispatch($command);

        $this->browserHelper->request('GET', '', true);
    }

    /**
     * @When I create a todo list named :todoListName
     */
    public function iCreateATodoListNamed(string $todoListNamed): void
    {
        $crawler = $this->browserHelper->crawler();
        $crawler->findElement(WebDriverBy::id('create-todo-list'))->sendKeys($todoListNamed)->submit();
    }

    /**
     * @Then :todoListName should have :numberOfTasks task(s)
     */
    public function shouldHaveTask(string $todoListName, int $numberOfTasks)
    {
        $todoList = $this->findTodoListNamed($todoListName);
        $text = $todoList->findElement(WebDriverBy::className('todo-list-count'))->getText();

        Assert::eq($text, '('.$numberOfTasks.')');
    }

    /**
     * @When I add a task named :taskName to the list :todoListName
     */
    public function iAddATaskNamedToTheList(string $taskName, string $todoListName)
    {
        $todoList = $this->findTodoListNamed($todoListName);

        $todoList->findElement(WebDriverBy::tagName('input'))->sendKeys($taskName)->submit();
    }

    private function findTodoListNamed(string $todoListName): WebDriverElement
    {
        $crawler = $this->browserHelper->crawler();
        $xpath = \Safe\sprintf('//span[text()=\'%s\']', $todoListName);
        $this->browserHelper->client()->waitFor($xpath, 2);

        return $crawler->findElement(WebDriverBy::xpath(\Safe\sprintf('//span[text()=\'%s\']/../..', $todoListName)));
    }
}
