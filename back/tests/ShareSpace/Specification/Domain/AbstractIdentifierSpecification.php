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

use Todo\ShareSpace\Domain\Identifier as AbstractIdentifier;
use PhpSpec\ObjectBehavior;

abstract class AbstractIdentifierSpecification extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($this->constructorArgument());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType($this->classNamespace());
    }

    public function it_is_an_identifier()
    {
        $this->shouldBeAnInstanceOf(AbstractIdentifier::class);
    }

    protected abstract function classNamespace(): string;
    protected abstract function constructorArgument();
}
