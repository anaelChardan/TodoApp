<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Domain\TodoList\Write\Task;

use Todo\Todo\Domain\TodoList\Write\TodoList;

class Task
{
    private Identifier $identifier;
    private Name $name;

    /** Below, only doctrine related field, forbidden to use */
    private ?TodoList $todoList = null;

    public function __construct(Identifier $identifier, Name $name, ?TodoList $todoList = null)
    {
        $this->identifier = $identifier;
        $this->name = $name;
        $this->todoList = $todoList;
    }

    /** Below is doctrine only, only allowed from the aggregate root */
    public function ofTodoList(TodoList $todoList): void
    {
        if (null === $this->todoList) {
            $this->todoList = $todoList;
        }
    }

    /** Below is test only */
    public function identifier(): Identifier
    {
        return $this->identifier;
    }

    public function name(): Name
    {
        return $this->name;
    }
}
