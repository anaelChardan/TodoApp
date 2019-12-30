<?php

namespace Specification\Todo\Todo\Domain\TodoList\Write\Task;

use Innmind\BlackBox\PHPUnit\BlackBox;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\UuidInterface;
use Todo\ShareSpace\Domain\Identifier as AbstractIdentifier;
use Todo\Tests\Todo\Set\Other\UuidSet;
use Todo\Todo\Domain\TodoList\Write\Task\Identifier;

class IdentifierSpec extends ObjectBehavior
{
    use BlackBox;

    function it_is_initializable()
    {
        $this->beConstructedWith(UuidSet::one());
        $this->shouldHaveType(Identifier::class);
    }

    function it_is_an_identifier()
    {
        $this->beConstructedWith(UuidSet::one());
        $this->shouldBeAnInstanceOf(AbstractIdentifier::class);
    }

    function it_is_equals()
    {
        $this
            ->forAll(UuidSet::any())
            ->take(1)
            ->then(function (UuidInterface $uuid) {
                $this->beConstructedWith($uuid);
                $this->equals(new Identifier($uuid))->shouldReturn(true);
            });
    }

    function it_does_not_equals()
    {
        $this
            ->forAll(UuidSet::any())
            ->take(1)
            ->then(function (UuidInterface $uuid) {
                $this->beConstructedWith($uuid);
                $this->equals(new Identifier(UuidSet::one()))->shouldReturn(false);
            });
    }
}
