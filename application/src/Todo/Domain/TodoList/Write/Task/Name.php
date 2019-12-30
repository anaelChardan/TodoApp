<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Write\Task;

use Todo\ShareSpace\Domain\Name as AbstractName;
use Webmozart\Assert\Assert;

final class Name extends AbstractName
{
    public static function fromString(string $name): Name
    {
        Assert::notEmpty($name, 'A task name cannot be empty');

        return new static($name);
    }
}
