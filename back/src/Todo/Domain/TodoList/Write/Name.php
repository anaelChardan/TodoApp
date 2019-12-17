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

use Webmozart\Assert\Assert;

final class Name
{
    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $name): self
    {
        Assert::notEmpty($name, 'A todo list name cannot be empty');

        return new self($name);
    }

    public function equals(Name $name): bool
    {
        return $name->name === $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
