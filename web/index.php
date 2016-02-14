<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 04.02.16
 * Time: 7:15 PM
 */

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';

$app->run();

