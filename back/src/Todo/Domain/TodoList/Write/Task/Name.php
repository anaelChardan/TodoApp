<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Write\Task;

final class Name extends \Todo\ShareSpace\Domain\Name
{
    protected const ERROR_MESSAGE_INSTANTIATION = 'A task name cannot be empty';
}
