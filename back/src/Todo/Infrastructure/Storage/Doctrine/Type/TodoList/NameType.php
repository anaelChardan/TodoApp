<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\Storage\Doctrine\Type\TodoList;

use Todo\ShareSpace\Infrastructure\Storage\Type\NameType as AbstractNameType;
use Todo\Todo\Domain\TodoList\Write\Name;

final class NameType extends AbstractNameType
{
    /**
     * {@inheritdoc}
     */
    protected function getFqcn(): string
    {
        return Name::class;
    }

    public function getName()
    {
        return 'todo_list_name';
    }
}
