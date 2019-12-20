<?php
/**
 * MenuPleaz Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 MenuPleaz
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\ShareSpace\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class KernelAwareTestCase extends KernelTestCase
{
    protected function setUp(): void
    {
        $this->bootKernel();
    }

    protected function getService(string $serviceName)
    {
        return static::$container->get($serviceName);
    }
}
