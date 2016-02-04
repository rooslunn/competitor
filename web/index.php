<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 04.02.16
 * Time: 7:15 PM
 */

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/', function () use ($app) {
    return 'Hello, Competitors!';
});

$app->run();