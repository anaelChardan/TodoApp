<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Specification\Todo\ShareSpace\Application\Symfony\Container\Compiler;

use Todo\ShareSpace\Application\Symfony\Container\Compiler\RegisterYmlValidationFile;
use Todo\Tests\TestingBoundedContext\Infrastructure\Application\DomainDrivenDesign\TestingBoundedContextExtension;
use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class RegisterYmlValidationFileSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(TestingBoundedContextExtension::pathStatic());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterYmlValidationFile::class);
    }

    public function it_loads_yml_file(ContainerBuilder $containerBuilder, Definition $validatorBuilder)
    {
        $containerBuilder->getDefinition('validator.builder')->willReturn($validatorBuilder);
        $validatorBuilder
            ->addMethodCall(
                'addYamlMappings',
                [["/srv/todo/tests/TestingBoundedContext/Infrastructure/Application/DomainDrivenDesign/../../../Application/test.yml"]]
            )->shouldBeCalled();
        $this->process($containerBuilder);
    }
}
