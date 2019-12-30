<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Domain;

abstract class Name
{
    private string $name;

    protected function __construct(string $name)
    {
        $this->name = $name;
    }

    abstract public static function fromString(string $name): Name;

    public function equals(Name $name): bool
    {
        return $name->name === $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
