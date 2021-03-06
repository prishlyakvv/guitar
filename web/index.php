<?php

use System\App;

const ROOT = __DIR__;

require_once ROOT . '/../vendor/autoload.php';

/**
 * Загружать классы по неймспейсу
 */
spl_autoload_register('AutoLoader');
function AutoLoader($className)
{
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    require_once ROOT . '/../'.$file.'.php';
}

//Инициализация
$app = App::getInstance();
$app->run();