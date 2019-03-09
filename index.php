<?php

// composer autoloading
require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/app.php';

$app['debug'] = @$_REQUEST['debug'] || false;

$app->run();