<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Application\DomainDrivenDesign;

interface BoundedContextExtension
{
    /**
     * Returns the name of the bounded context.
     * It is used to activate the extension in the application container (config/Todo.yml).
     */
    public function name(): string;

    /**
     * Returns the the path to the root of the bounded context.
     */
    public function path(): string;

    /**
     * Returns an array xml definition to namespace of all entities.
     *
     * @return string[]
     */
    public function doctrineMapping(): array;
}
