<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\EndToEnd\Behat;

use Behat\Behat\Context\Context;
use Todo\Tests\Behat\DatabasePurger;

class DatabaseContext implements Context
{
    private DatabasePurger $databasePurger;

    public function __construct(DatabasePurger $databasePurger)
    {
        $this->databasePurger = $databasePurger;
    }

    /**
     * @AfterScenario
     * @BeforeScenario
     */
    public function purgeDatabase(): void
    {
        ($this->databasePurger)();
    }
}
