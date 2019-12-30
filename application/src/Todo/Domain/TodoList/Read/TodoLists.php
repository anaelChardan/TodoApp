<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Read;

use Ds\Vector;
use Todo\ShareSpace\Domain\Read\ReadModel;

class TodoLists implements ReadModel
{
    /** @var Vector<TodoList> */
    private Vector $todoLists;

    /**
     * @param array<TodoList> $todoLists
     */
    public function __construct(array $todoLists)
    {
        /** @var Vector<TodoList> $todoListVector */
        $todoListVector = new Vector($todoLists);
        $this->todoLists = $todoListVector;
    }

    /**
     * @return array<mixed>
     */
    public function normalize(): array
    {
        return $this->todoLists->map(fn (TodoList $todoList): array => $todoList->normalize())->toArray();
    }
}
