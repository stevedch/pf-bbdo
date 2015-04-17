<?php

define('img', __DIR__);
ini_set('display_errors', 0);
require_once __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../src/app.php';
require __DIR__ . '/../app/config/prod.php';
require __DIR__ . '/../src/routes.php';
$app->run();
