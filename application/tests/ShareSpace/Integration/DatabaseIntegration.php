<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\ShareSpace\Integration;

use Doctrine\ORM\EntityManagerInterface;

final class DatabaseIntegration extends KernelAwareTestCase
{
    public function test_database_connection(): void
    {
        $this->expectNotToPerformAssertions();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getService('doctrine.orm.default_entity_manager');

        $entityManager->getConnection()->getSchemaManager()->listTables();
    }
}
