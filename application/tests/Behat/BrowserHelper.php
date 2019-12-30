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

use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Symfony\Component\Panther\PantherTestCaseTrait;

final class BrowserHelper
{
    use PantherTestCaseTrait;

    private Client $client;
    private array $lastRequest = [];
    private ?Crawler $lastCrawler = null;

    public function __construct(string $seleniumHost, string $baseUri)
    {
        echo "CREATE\n";
        $this->client = Client::createSeleniumClient($seleniumHost, null,$baseUri);
    }

    public function client(): Client
    {
        return $this->client;
    }

    public function request(string $method, string $uri, bool $force = false, array $parameters = [], array $files = [], array $server = [], string $content = null, bool $changeHistory = true): Crawler
    {
        $request = [
            'method' => $method,
            'uri' => $uri,
            'parameters' => $parameters,
            'files' => $files,
            'server' => $server,
            'content' => $content,
            'changeHistory' => $changeHistory
        ];

        if ($request === $this->lastRequest) {
            if ($force === false) {
                return $this->lastCrawler;
            }
        }

        $this->lastRequest = $request;

        $crawler = $this->client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
        $this->lastCrawler = $crawler;

        return $this->lastCrawler;
    }

    public function crawler(): Crawler
    {
        if (null === $this->lastCrawler) {
            throw new \LogicException('You may need to request a page before');
        }

        return $this->lastCrawler;
    }
}
