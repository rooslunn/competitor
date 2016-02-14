<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 14.02.16
 * Time: 10:16 AM
 */

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
//use Silex\Provider\UrlGeneratorServiceProvider;
//use Silex\Provider\ValidatorServiceProvider;
//use Silex\Provider\ServiceControllerServiceProvider;
//use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();

//$app->register(new ServiceControllerServiceProvider());
//$app->register(new UrlGeneratorServiceProvider());
//$app->register(new ValidatorServiceProvider());
//$app->register(new HttpFragmentServiceProvider());
$app->register(new TwigServiceProvider());
$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
    return $twig;
}));

return $app;