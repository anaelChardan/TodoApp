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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RenderExceptionController extends AbstractController
{
    public function renderAction(FlattenException $exception): JsonResponse
    {
        $data = [
            'code' => $exception->getStatusCode(),
            'message' => $exception->getMessage(),
            'errors' => $exception->getErrors(),
        ];

        if (true === $this->getParameter('kernel.debug')) {
            $data['file'] = $exception->getFile();
            $data['line'] = $exception->getLine();
            $data['class'] = $exception->getClass();
        }

        return new JsonResponse($data, $exception->getStatusCode());
    }
}
