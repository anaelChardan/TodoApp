<?php

namespace Specification\Todo\Todo\Domain\TodoList\Write\Task;

use Innmind\BlackBox\PHPUnit\BlackBox;
use Innmind\BlackBox\Set\Strings;
use PhpSpec\ObjectBehavior;
use Todo\Todo\Domain\TodoList\Write\Task\Name;

class NameSpec extends ObjectBehavior
{
    use BlackBox;

    public function it_is_initializable()
    {
        $this
            ->forAll(Strings::any())
            ->take(1)
            ->then(function (string $name) {
                $this->beConstructedThrough('fromString', [$name]);
                $this->shouldHaveType(Name::class);
            });
    }

    public function it_does_not_allow_an_empty_name()
    {
        $this->beConstructedThrough('fromString', ['']);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    public function it_equals_well()
    {
        $this
            ->forAll(Strings::any(128))
            ->take(1)
            ->then(function (string $string) {
                $this->beConstructedThrough('fromString', [$string]);
                $this->equals(Name::fromString($string))->shouldReturn(true);
            });
    }

    public function it_equals_false_if_false()
    {
        $this->beConstructedThrough('fromString', ['michel']);
        $this->equals(Name::fromString('sardou'))->shouldReturn(false);
    }
}
