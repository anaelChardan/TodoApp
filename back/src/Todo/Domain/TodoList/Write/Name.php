<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Write;

use Todo\ShareSpace\Domain\Name as AbstractName;

final class Name extends AbstractName
{
    protected const ERROR_MESSAGE_INSTANTIATION = 'A todo list name cannot be empty';
}
