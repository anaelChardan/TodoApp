<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\Integration\Storage;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Todo\Tests\ShareSpace\Integration\KernelAwareTestCase;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\IdentifierSet;
use Todo\Tests\Todo\Set\Domain\TodoList\Task\NameSet;
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Domain\TodoList\Write\Repository;

final class TodoListDatabaseIntegration extends KernelAwareTestCase
{
    public function test_it_saves_a_todo_list()
    {
        $todoList = TodoListSet::one();
        $taskName = NameSet::one();
        $taskIdentifier = IdentifierSet::one();

        $todoList->addTask($taskIdentifier, $taskName);
        /** @var Repository $repository */
        $repository = $this->getService(Repository::class);
        $repository->save($todoList);
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getService(EntityManagerInterface::class);
        $entityManager->flush();

        Assert::assertNotNull($repository->get($todoList->identifier()));
    }
}
