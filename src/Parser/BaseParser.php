<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 17.02.16
 * Time: 2:00 PM
 */

namespace SV\Parser;

use GuzzleHttp\Client as GuzzleClient;
use Goutte\Client as GoutteClient;
use SV\Provider\ProxyProvider;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class BaseParser
 * @package SV\Parser
 */
class BaseParser
{
    const ENTITY_NOT_FOUND = 'Entity not found';

    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * @var GoutteClient
     */
    protected $goutteClient;

    public function __construct()
    {
        $this->guzzleClient = new GuzzleClient([
            'proxy' => ProxyProvider::getRandomProxy(),
        ]);

        $this->goutteClient = new GoutteClient();
        $this->goutteClient->setClient($this->guzzleClient);

    }

    public static function requestHtmlCallback(string $method, string $url, callable $htmlFixCallback): Crawler
    {
        $guzzle = new GuzzleClient([
            'proxy' => ProxyProvider::getRandomProxy(),
        ]);
        $response = $guzzle->request($method, $url);
        $html = (string) $response->getBody();
        $htmlFixCallback($html);
        return new Crawler($html);
    }

    public function screen(string ...$parts)
    {
        array_unshift($parts, date('Y-m-d H:i:s'));
        echo(implode(' - ', $parts) . PHP_EOL);
    }
}