<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 14.02.16
 * Time: 11:19 AM
 */

// configure your app for the production environment
$app['twig.path'] = array(__DIR__.'/../templates');
$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');