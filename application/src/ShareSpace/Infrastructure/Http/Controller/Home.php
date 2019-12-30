<?php
/**
 * Todo Project.
 *
 * @author    Anael Chardan <anael.chardan@gmail.com>
 * @copyright 2019 Todo
 * @license   Proprietary
 */
declare(strict_types=1);

namespace Todo\ShareSpace\Infrastructure\Http\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class Home
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(): Response
    {
        $response = new Response();

        $response->setContent($this->twig->render('base.html.twig'));

        return $response;
    }
}
