<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Application\Read\GetTodoListDetails;

use ConvenientImmutability\Immutable;
use Todo\ShareSpace\Application\DomainDrivenDesign\Query;

final class GetTodoListDetails implements Query
{
    use Immutable;

    public ?string $identifier = null;
}
