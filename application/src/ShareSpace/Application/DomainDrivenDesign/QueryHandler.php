<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Application\DomainDrivenDesign;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

interface QueryHandler extends MessageHandlerInterface
{
}
