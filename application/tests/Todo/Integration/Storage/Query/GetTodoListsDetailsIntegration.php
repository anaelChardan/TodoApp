<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\Integration\Storage\Query;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Todo\Tests\ShareSpace\Integration\KernelAwareTestCase;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\TaskSet;
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Domain\TodoList\Read\GetTodoListsDetails;
use Todo\Todo\Domain\TodoList\Read\Task;
use Todo\Todo\Domain\TodoList\Read\TodoList;
use Todo\Todo\Domain\TodoList\Read\TodoLists;
use Todo\Todo\Domain\TodoList\Write;
use Todo\Todo\Domain\TodoList\Write\Repository;

final class GetTodoListsDetailsIntegration extends KernelAwareTestCase
{
    public function test_it_gets_the_right_read_model()
    {
        /** @var Repository $repository */
        $repository = $this->getService(Repository::class);
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getService(EntityManagerInterface::class);

        $query = $this->getService(GetTodoListsDetails::class);

        $todoList = TodoListSet::one();
        $taskForReadModel = [];
        $todoListB = TodoListSet::one();
        $taskForReadModelB = [];

        /** @var Write\Task\Task $task */
        foreach (TaskSet::any($todoList)->take(10)->values() as $task) {
            $todoList->addTask($task);
            $taskForReadModel[] = new Task((string) $task->identifier(), (string) $task->name());
        }

        $todoListReadModel = new TodoList((string) $todoList->identifier(), (string) $todoList->name(), 10, $taskForReadModel);

        /** @var Write\Task\Task $task */
        foreach (TaskSet::any($todoListB)->take(3)->values() as $task) {
            $todoListB->addTask($task);
            $taskForReadModelB[] = new Task((string) $task->identifier(), (string) $task->name());
        }

        $todoListReadModelB = new TodoList((string) $todoListB->identifier(), (string) $todoListB->name(), 3, $taskForReadModelB);

        $todoLists = new TodoLists([$todoListReadModel, $todoListReadModelB]);

        $repository->save($todoList);
        $repository->save($todoListB);

        $entityManager->flush();

        Assert::assertEqualsCanonicalizing($todoLists, ($query)());
    }
}
