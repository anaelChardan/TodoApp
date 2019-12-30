<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Todo\Infrastructure\Storage\InMemory;

use Ds\Map;

final class Store
{
    private Map $values;

    public function __construct()
    {
        $this->values = new Map();
    }

    /**
     * @psalm-suppress MissingParamType
     */
    public function set(string $key, $value): void
    {
        $this->values->put($key, $value);
    }

    /**
     * @psalm-suppress MissingReturnType
     */
    public function get(string $key)
    {
        return $this->values->get($key);
    }

    public function all(): Map
    {
        return $this->values;
    }
}
