<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Domain\TodoList\Write\Task;

final class Task
{
    private Identifier $identifier;
    private Name $name;

    public function __construct(Identifier $identifier, Name $name)
    {
        $this->identifier = $identifier;
        $this->name = $name;
    }
}
