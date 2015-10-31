#!/usr/bin/env php
<?php
set_time_limit(0);

use System\App;

const ROOT = __DIR__;

require_once ROOT . '/../vendor/autoload.php';

spl_autoload_register('AutoLoader');
function AutoLoader($className)
{
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    require_once ROOT . '/../'.$file.'.php';
}

$app = App::getInstance(App::RUN_IN_CONSOLE);
$app->setArgs($argv);
$app->run();