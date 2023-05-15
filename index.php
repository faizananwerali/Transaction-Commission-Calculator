<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\Application;
use App\Services\Config;
use App\Services\EnvLoader;

EnvLoader::load(__DIR__);
Config::load(__DIR__);

$app = new Application();
$app->run($argv);