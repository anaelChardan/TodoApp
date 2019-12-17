<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

namespace Todo\Todo\Application\Read\CountTaskOfTodoList;

use ConvenientImmutability\Immutable;
use Todo\ShareSpace\Application\DomainDrivenDesign\Query;

final class CountTaskOfTodoList implements Query
{
    use Immutable;

    public ?string $todoListName = null;
}
