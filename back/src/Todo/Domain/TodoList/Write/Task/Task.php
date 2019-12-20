<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Domain\TodoList\Write\Task;

class Task
{
    private Identifier $identifier;
    private Name $name;

    /** Below, only doctrine related field, forbidden to use */
    private TodoList $todoList;

    public function __construct(Identifier $identifier, Name $name)
    {
        $this->identifier = $identifier;
        $this->name = $name;
    }
}
