<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Application\Write;

use Symfony\Component\Validator\Constraint;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class UniqueNameConstraint extends Constraint
{
    /** @var string */
    public $queryClass;

    /** @var string */
    public $entityName;

    /** @var string */
    public $message = 'The {{ entity_name }} named {{ identifier }} already exists';
}
