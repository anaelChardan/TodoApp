<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Domain\TodoList\Read;

use Todo\ShareSpace\Domain\Read\ReadModel;

final class Task implements ReadModel
{
    private string $identifier;
    private string $name;

    public function __construct(string $identifier, string $name)
    {
        $this->identifier = $identifier;
        $this->name = $name;
    }

    /**
     * @return array<mixed>
     */
    public function normalize(): array
    {
        return [
            'identifier' => $this->identifier,
            'name' => $this->name,
        ];
    }
}
