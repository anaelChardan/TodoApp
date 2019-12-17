<?php

namespace Specification\Todo\Todo\Infrastructure\Storage\TodoList;

use Ds\Map;
use Innmind\BlackBox\PHPUnit\BlackBox;
use Innmind\BlackBox\Set\Strings;
use PhpSpec\ObjectBehavior;
use Todo\Todo\Infrastructure\Storage\TodoList\Store;

class StoreSpec extends ObjectBehavior
{
    use BlackBox;

    function it_is_initializable()
    {
        $this->shouldHaveType(Store::class);
    }

    function it_stores_a_thing()
    {
        $values = new Map();

        $this
            ->forAll(Strings::any(), Strings::any())
            ->then(function (string $key, string $value) use ($values) {
                $values->put($key, $value);
                $this->set($key, $value);
                $this->get($key)->shouldReturn($value);
            });

        $this->all()->toArray()->shouldReturn($values->toArray());
    }
}
