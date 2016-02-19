<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 19.02.16
 * Time: 6:53 PM
 */

namespace SV\Parser;


class TestParser extends BaseParser implements IParser
{
    const TEST_URL = 'http://httpbin.org/';

    public function run()
    {
        $crawler = $this->goutteClient->request('GET', self::TEST_URL);
        $this->screen('Origin header', $crawler->filter('div.mp > h2')->eq(0)->text());

        $crawler = self::requestHtmlCallback('GET', self::TEST_URL, [$this, 'fixHtml']);
        $this->screen('Fixed header', $crawler->filter('div.mp > h2')->eq(0)->text());
    }

    protected function fixHtml(&$html)
    {
        $html = str_replace('<h2 id="ENDPOINTS">ENDPOINTS</h2>', '<h2 id="ENDPOINTS">RUSS</h2>', $html);
    }
}