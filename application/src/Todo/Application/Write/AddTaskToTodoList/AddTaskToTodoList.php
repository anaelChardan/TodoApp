<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Application\Write\AddTaskToTodoList;

use ConvenientImmutability\Immutable;
use Todo\ShareSpace\Application\DomainDrivenDesign\Command;

final class AddTaskToTodoList implements Command
{
    use Immutable;

    public ?string $todoListIdentifier = null;
    public ?string $identifier = null;
    public ?string $name = null;
}
