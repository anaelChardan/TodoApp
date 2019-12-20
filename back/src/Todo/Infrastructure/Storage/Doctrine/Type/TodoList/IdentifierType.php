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

use Todo\ShareSpace\Infrastructure\Storage\Type\IdentifierType as AbstractIdentifierType;
use Todo\Todo\Domain\TodoList\Write\Identifier;

final class IdentifierType extends AbstractIdentifierType
{
    /**
     * {@inheritdoc}
     */
    protected function getFqcn(): string
    {
        return Identifier::class;
    }

    public function getName()
    {
        return 'todo_list_identifier';
    }
}
