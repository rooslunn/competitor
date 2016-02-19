<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 19.02.16
 * Time: 7:03 PM
 */

namespace SV\Job;

use SV\Parser\TestParser;

class TestJob
{
    public static function run()
    {
        $parser = new TestParser();
        $parser->run();
    }
}