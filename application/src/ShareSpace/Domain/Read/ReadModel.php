<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Domain\Read;

interface ReadModel
{
    /**
     * @return array<mixed>
     */
    public function normalize(): array;
}
