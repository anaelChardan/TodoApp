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
use Behat\Behat\Tester\Exception\PendingException;

final class TodoContext implements Context
{
    /**
     * @Given I'm connected as :username
     */
    public function imConnectedAs(string $username): void
    {
        throw new PendingException();
    }

    /**
     * @When I create a todo list named :todoListName
     */
    public function iCreateATodoListNamed(string $todoListName)
    {
        throw new PendingException();
    }

    /**
     * @Then :todoListName should have :numberOfTasks task(s)
     */
    public function shouldHaveTask(string $todoListName, int $numberOfTasks)
    {
        throw new PendingException();
    }
}
