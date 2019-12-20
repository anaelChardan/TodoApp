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

use Webmozart\Assert\Assert;

abstract class Name
{
    private string $name;

    protected const ERROR_MESSAGE_INSTANTIATION = '';

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString(string $name): self
    {
        Assert::notEmpty($name, static::ERROR_MESSAGE_INSTANTIATION);

        return new static($name);
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
