<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Application\Write\AddTodoList;

use Todo\ShareSpace\Application\DomainDrivenDesign\CommandHandler;
use Todo\Todo\Domain\TodoList\Write\Identifier;
use Todo\Todo\Domain\TodoList\Write\Name;
use Todo\Todo\Domain\TodoList\Write\Repository;
use Todo\Todo\Domain\TodoList\Write\TodoList;

final class AddTodoListHandler implements CommandHandler
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddTodoList $addTodoList): void
    {
        $this
            ->repository
            ->save(
                    new TodoList(
                    Identifier::fromUuidString((string) $addTodoList->identifier),
                    Name::fromString((string) $addTodoList->name)
                )
            );
    }
}
