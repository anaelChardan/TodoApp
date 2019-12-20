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

use Todo\ShareSpace\Infrastructure\Storage\Type\NameType as AbstractNameType;
use Todo\Todo\Domain\TodoList\Write\Task\Name;

final class NameType extends AbstractNameType
{
    protected function getFqcn(): string
    {
        return Name::class;
    }

    public function getName()
    {
        return 'task_list_identifier';
    }
}
