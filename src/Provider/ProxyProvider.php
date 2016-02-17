<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 17.02.16
 * Time: 1:13 PM
 */

namespace SV\Provider;


class ProxyProvider
{
    public static function getRandomProxy()
    {
        return [
            'http' => 'tcp://software:9LWNDBhx@198.203.28.94:60099',
            'https' => 'tcp://software:9LWNDBhx@198.203.28.94:60099',
        ];
    }
}