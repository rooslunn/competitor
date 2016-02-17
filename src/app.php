<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 14.02.16
 * Time: 10:16 AM
 */

use Silex\Application;
use Silex\Provider\TwigServiceProvider;

$app = new Application();

$app->register(new TwigServiceProvider());
$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
    return $twig;
}));

return $app;