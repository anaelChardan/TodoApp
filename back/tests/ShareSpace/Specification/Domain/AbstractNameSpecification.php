<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Specification\Todo\Tests\ShareSpace\Domain;

use Todo\ShareSpace\Domain\Name as AbstractName;
use PhpSpec\ObjectBehavior;

abstract class AbstractNameSpecification extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($this->constructorArgument());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType($this->classNamespace());
    }

    public function it_is_a_name()
    {
        $this->shouldBeAnInstanceOf(AbstractName::class);
    }

    public function it_does_not_allow_an_empty_name()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->during('__construct', ['']);
    }

    protected abstract function classNamespace(): string;
    protected abstract function constructorArgument();
}
