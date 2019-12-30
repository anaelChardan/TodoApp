<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\Storage\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Todo\Todo\Domain\TodoList\Write\Identifier;
use Todo\Todo\Domain\TodoList\Write\Repository;
use Todo\Todo\Domain\TodoList\Write\TodoList;
use Todo\Todo\Domain\TodoList\Write\UnknownTodoList;

final class DoctrineTodoListRepository implements Repository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(TodoList $todoList): void
    {
        $this->entityManager->persist($todoList);
    }

    public function get(Identifier $identifier): TodoList
    {
        try {
            $todoList = $this->entityManager->find(TodoList::class, $identifier);
        } catch (\Exception $exception) {
            throw new \RuntimeException('You cannot get the TodoList', (int) $exception->getCode(), $exception);
        }

        if (null === $todoList) {
            throw new UnknownTodoList($identifier);
        }

        return $todoList;
    }
}
