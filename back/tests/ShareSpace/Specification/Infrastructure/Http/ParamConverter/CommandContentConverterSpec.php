<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Specification\Todo\ShareSpace\Infrastructure\Http\ParamConverter;

use Todo\ShareSpace\Application\DomainDrivenDesign\Command;
use Todo\ShareSpace\Infrastructure\Http\ParamConverter\CommandContentConverter;
use PhpSpec\ObjectBehavior;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class CommandContentConverterSpec extends ObjectBehavior
{
    public function let(SerializerInterface $serializer)
    {
        $this->beConstructedWith($serializer);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CommandContentConverter::class);
    }

    public function it_is_a_param_converter()
    {
        $this->shouldBeAnInstanceOf(ParamConverterInterface::class);
    }

    public function it_supports_only_commands(ParamConverter $configuration)
    {
        $configuration->getClass()->willReturn(FakeCommand::class);
        $this->supports($configuration)->shouldReturn(true);
        $configuration->getClass()->willReturn(FakeNothing::class);
        $this->supports($configuration)->shouldReturn(false);
    }

    public function it_serializes_the_request(SerializerInterface $serializer, Request $request, ParamConverter $configuration, ParameterBag $attributes)
    {
        $content = json_encode(['content' =>  'michel']);
        $request->getContent()->willReturn($content);

        $configuration->getClass()->willReturn(FakeCommand::class);
        $configuration->getName()->willReturn('fakeCommand');

        $fakeCommand = new FakeCommand();
        $serializer->deserialize($content, FakeCommand::class, 'json')->willReturn($fakeCommand);

        $request->attributes = $attributes;
        $attributes->set('fakeCommand', $fakeCommand)->shouldBeCalled();

        $this->apply($request, $configuration)->shouldReturn(true);
    }
}

class FakeCommand implements Command {}
class FakeNothing {}
