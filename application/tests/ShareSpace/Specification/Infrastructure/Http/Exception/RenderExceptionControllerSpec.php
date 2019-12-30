<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Specification\Todo\ShareSpace\Infrastructure\Http\Exception;

use Todo\ShareSpace\Infrastructure\Http\Exception\FlattenException;
use Todo\ShareSpace\Infrastructure\Http\Exception\RenderExceptionController;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RenderExceptionControllerSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $fake = new class {
            public function get(string $name): bool
            {
                return true;
            }
        };
        $this->setContainer($container);
        $container->has('parameter_bag')->willReturn(true);
        $container->get('parameter_bag')->willReturn($fake);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(RenderExceptionController::class);
    }

    public function it_is_a_controller()
    {
        $this->shouldBeAnInstanceOf(AbstractController::class);
    }

    public function it_renders_an_exception()
    {
        $exception = FlattenException::createFrom(new \Exception("A message", 500));
        $path = __DIR__ . '/RenderExceptionControllerSpec.php';

        $this
            ->renderAction($exception)
            ->shouldBeLike(
                new JsonResponse(
                    [
                        'code' => 500,
                        'message' => 'A message',
                        'errors' => [],
                        'file' => $path,
                        'line' => 47,
                        'class' => \Exception::class
                    ],
                    500
                )
            );
    }
}
