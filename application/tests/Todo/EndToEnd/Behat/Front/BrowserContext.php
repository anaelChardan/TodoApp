<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\Tests\Todo\EndToEnd\Behat\Front;

use Behat\Behat\Context\Context;
use Todo\Tests\Behat\BrowserHelper;

class BrowserContext implements Context
{
    private BrowserHelper $browserHelper;

    public function __construct(BrowserHelper $browserHelper)
    {
        $this->browserHelper = $browserHelper;
    }

    /**
     * @AfterScenario
     */
    public function closeBrowser(): void
    {
        $this->browserHelper->client()->close();
    }
}
