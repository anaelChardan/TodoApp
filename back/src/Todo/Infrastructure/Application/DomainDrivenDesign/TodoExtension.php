<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\Application\DomainDrivenDesign;

use function Safe\sprintf;
use Todo\ShareSpace\Application\DomainDrivenDesign\BoundedContextExtension;

final class TodoExtension implements BoundedContextExtension
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'todo';
    }

    /**
     * {@inheritdoc}
     */
    public function path(): string
    {
        return sprintf('%s/../../..', __DIR__);
    }

    public function doctrineMapping(): array
    {
        $path = $this->path() . '/Infrastructure/Storage/Doctrine/Mapping';

        return [
            $path => 'Todo\Todo\Domain\TodoList\Write',
            $path.'/Task' => 'Todo\Todo\Domain\TodoList\Write\Task',
        ];
    }
}
