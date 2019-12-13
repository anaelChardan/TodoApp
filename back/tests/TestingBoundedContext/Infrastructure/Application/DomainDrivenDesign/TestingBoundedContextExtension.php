<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\TestingBoundedContext\Infrastructure\Application\DomainDrivenDesign;

use Todo\ShareSpace\Application\DomainDrivenDesign\BoundedContextExtension;

final class TestingBoundedContextExtension implements BoundedContextExtension
{
    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return 'testing';
    }

    /**
     * {@inheritdoc}
     */
    public function path(): string
    {
        return self::pathStatic();
    }

    public static function pathStatic(): string
    {
        return \sprintf('%s/../../..', __DIR__);
    }
}
