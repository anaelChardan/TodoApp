<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Infrastructure\Http\Exception;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;

final class MessengerValidationExceptionListener extends ErrorListener
{
    /**
     * {@inheritdoc}
     */
    protected function duplicateRequest(\Throwable $exception, Request $request): Request
    {
        return parent::duplicateRequest(FlattenException::createFrom($exception), $request);
    }
}
