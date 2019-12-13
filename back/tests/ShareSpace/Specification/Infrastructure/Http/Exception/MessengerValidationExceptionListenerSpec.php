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

use Todo\ShareSpace\Infrastructure\Http\Exception\MessengerValidationExceptionListener;
use Todo\ShareSpace\Infrastructure\Http\Exception\RenderExceptionController;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;

final class MessengerValidationExceptionListenerSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(RenderExceptionController::class, null);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(MessengerValidationExceptionListener::class);
    }

    public function it_extends_symfony()
    {
        $this->shouldBeAnInstanceOf(ErrorListener::class);
    }
}
