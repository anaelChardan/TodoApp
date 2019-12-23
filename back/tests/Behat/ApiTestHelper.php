<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Behat;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;

final class ApiTestHelper
{
    private KernelInterface $kernel;
    private RouterInterface $router;

    public function __construct(KernelInterface $kernel, RouterInterface $router)
    {
        $this->kernel = $kernel;
        $this->router = $router;
    }

    public function jsonPost(array $content, string $routeName): JsonResponse
    {
        return $this->query($content, $routeName, 'POST');
    }

    public function jsonGet(array $content, string $routeName): JsonResponse
    {
        return $this->query($content, $routeName, 'GET');
    }

    private function query(array $content, string $routeName, string $method): JsonResponse
    {
        return $this->kernel->handle(
            Request::create(
                $this->router->generate($routeName, []),
                $method,
                [],
                [],
                [],
                [],
                \Safe\json_encode($content)
            )
        );
    }
}
