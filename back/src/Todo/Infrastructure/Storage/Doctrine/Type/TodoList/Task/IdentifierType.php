<?php
/**
 * MenuPleaz Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 MenuPleaz
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\Storage\Doctrine\Type\TodoList\Task;

use Todo\ShareSpace\Infrastructure\Storage\Type\IdentifierType as AbstractIdentifierType;
use Todo\Todo\Domain\TodoList\Write\Task\Identifier;

final class IdentifierType extends AbstractIdentifierType
{
    protected function getFqcn(): string
    {
        return Identifier::class;
    }

    public function getName()
    {
        return 'task_list_identifier';
    }
}
