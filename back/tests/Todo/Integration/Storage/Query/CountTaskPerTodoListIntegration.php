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
use Todo\Tests\Todo\Set\Domain\TodoList\TodoListSet;
use Todo\Todo\Domain\TodoList\Read\CountTaskForTodoList;
use Todo\Todo\Domain\TodoList\Write\Repository;

final class CountTaskPerTodoListIntegration extends KernelAwareTestCase
{
    public function test_it_counts_well_the_tasks_for_a_given_todo_list()
    {
        /** @var Repository $repository */
        $repository = $this->getService(Repository::class);
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getService(EntityManagerInterface::class);

        $query = $this->getService(CountTaskForTodoList::class);

        $todoList = TodoListSet::one();
        $todoListB = TodoListSet::one();

        foreach (NameSet::any()->take(10)->values() as $name) {
            $todoList->addTask(IdentifierSet::one(), $name);
        }

        foreach (NameSet::any()->take(3)->values() as $name) {
            $todoListB->addTask(IdentifierSet::one(), $name);
        }

        $repository->save($todoList);
        $repository->save($todoListB);

        $entityManager->flush();

        Assert::assertEquals(10, ($query)($todoList->name()->__toString()));
        Assert::assertEquals(3, ($query)($todoListB->name()->__toString()));
    }
}
