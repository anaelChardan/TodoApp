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
use Todo\Tests\Todo\Set\Domain\TodoList\Task\IdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\NameSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\TaskSet;
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Domain\TodoList\Read\GetTodoListDetails;
use Todo\Todo\Domain\TodoList\Read\Task;
use Todo\Todo\Domain\TodoList\Read\TodoList;
use Todo\Todo\Domain\TodoList\Write;
use Todo\Todo\Domain\TodoList\Write\Repository;

final class GetTodoListDetailsIntegration extends KernelAwareTestCase
{
    public static function taskProvider(): array
    {
        return [[10], [3]];
    }

    /**
     * @dataProvider taskProvider
     */
    public function test_it_get_the_right_read_model_for_a_given_todo_list(int $numberOfTasks)
    {
        /** @var Repository $repository */
        $repository = $this->getService(Repository::class);
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getService(EntityManagerInterface::class);

        $query = $this->getService(GetTodoListDetails::class);

        $todoList = TodoListSet::one();
        $taskForReadModel = [];

        /** @var Write\Task\Name $name */
        foreach (NameSet::any()->take($numberOfTasks)->values() as $name) {
            $identifier = IdentifierSet::one();
            $todoList->addTask(new Write\Task\Task($identifier, $name));
            $taskForReadModel[] = new Task((string) $identifier, (string) $name);
        }

        $todoListReadModel = new TodoList((string) $todoList->identifier(), (string) $todoList->name(), $numberOfTasks, $taskForReadModel);
        $repository->save($todoList);
        $entityManager->flush();

        /** @var TodoList $result */
        $result = ($query)((string) $todoList->identifier());
        Assert::assertEqualsCanonicalizing($todoListReadModel->normalize(), $result->normalize());
    }
}
