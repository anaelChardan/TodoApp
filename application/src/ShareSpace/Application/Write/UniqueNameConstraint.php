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
    public string $queryClass;
    public string $entityName;
    public string $message = 'The {{ entity_name }} named {{ identifier }} already exists';
}
