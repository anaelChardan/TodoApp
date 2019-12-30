<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Application\Write\AddTodoList;

use ConvenientImmutability\Immutable;
use Todo\ShareSpace\Application\DomainDrivenDesign\Command;

final class AddTodoList implements Command
{
    use Immutable;

    public ?string $identifier = null;
    public ?string $name = null;
}
