<?php

namespace Todo\Todo\Infrastructure\Storage\TodoList;

use Todo\Todo\Domain\TodoList\Write\Identifier;
use Todo\Todo\Domain\TodoList\Write\Repository;
use Todo\Todo\Domain\TodoList\Write\TodoList;

class InMemoryRepository implements Repository
{
    private Store $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function save(TodoList $todoList): void
    {
        $this->store->set($todoList->identifier()->__toString(), $todoList);
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function get(Identifier $identifier): TodoList
    {
        return $this->store->get($identifier->__toString());
    }
}
