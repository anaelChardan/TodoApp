<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Specification\Todo\ShareSpace\Application\Symfony\Container;

use Todo\ShareSpace\Application\Symfony\Container\SymfonyExtension;
use Todo\Tests\TestingBoundedContext\Infrastructure\Application\DomainDrivenDesign\TestingBoundedContextExtension;
use PhpSpec\ObjectBehavior;

final class SymfonyExtensionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new TestingBoundedContextExtension());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SymfonyExtension::class);
    }

    public function it_has_a_namespace()
    {
        $this->getNamespace()->shouldReturn('http://example.org/schema/dic/testing');
    }

    public function it_has_an_xsd_validation_base_path()
    {
        $this->getXsdValidationBasePath()->shouldReturn('');
    }

    public function it_has_an_alias()
    {
        $this->getAlias()->shouldReturn('testing');
    }
}
