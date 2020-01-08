<?php

/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */

declare(strict_types=1);

namespace Todo\ShareSpace\Tool\Mercure;

final class JwtProvider
{
    private string $jwtToken;

    public function __construct(string $jwtToken)
    {
        $this->jwtToken = $jwtToken;
    }

    public function __invoke(): string
    {
        return $this->jwtToken;
    }
}
