<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Write;

final class UnknownTodoList extends \Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct(Identifier $identifier, int $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            \sprintf('There is no %s with identifier "%s"', TodoList::class, (string) $identifier),
            $code,
            $previous
        );
    }
}
