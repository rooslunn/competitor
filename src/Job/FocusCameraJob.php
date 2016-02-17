<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 17.02.16
 * Time: 1:12 PM
 */

namespace SV\Job;

use SV\Parser\FocusCameraParser;

class FocusCameraJob
{
    public static function run()
    {
        $parser = new FocusCameraParser();
        $parser->run();
    }
}