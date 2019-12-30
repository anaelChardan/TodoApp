<?php

namespace Specification\Todo\Todo\Application\Write\AddTodoList;

use Innmind\BlackBox\PHPUnit\BlackBox;
use Innmind\BlackBox\Set\Strings;
use PhpSpec\ObjectBehavior;
use Todo\ShareSpace\Application\DomainDrivenDesign\Command;
use Todo\Todo\Application\Write\AddTodoList\AddTodoList;

class AddTodoListSpec extends ObjectBehavior
{
    use BlackBox;

    function it_is_initializable()
    {
        $this->shouldHaveType(AddTodoList::class);
    }

    function it_is_a_command()
    {
        $this->shouldBeAnInstanceOf(Command::class);
    }

    function it_needs_a_name_and_an_identifier()
    {
        $this
            ->forAll(Strings::any(), Strings::any())
            ->take(1)
            ->then(function (string $identifier, string $name) {
                $this->identifier = $identifier;
                $this->name = $name;
            });
    }
}
