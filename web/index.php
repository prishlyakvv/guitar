<?php

use System\App;

require_once '../vendor/autoload.php';

/**
 * Загружать классы по неймспейсу
 */
spl_autoload_register('AutoLoader');
function AutoLoader($className)
{
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    require_once '../'.$file.'.php';
}

//Инициализация
$app = App::getInstance();

/**
 * Для продакшен сервера вызвать
 * Будет учитываться при использовании кеша
 *
 * Можно сделать отдельный файл фронт контроллер для теста и прод
 */
//$app->setProd(true);

/**
 * Выбор любого из компонентов по идее лучше сделать по умолчанию
 * Чтобы указывать только в случае использования своих измененых компонентов
 *
 * Привел пример как можно использовать свои компоненты (закоментировано)
 */

/*
//Выбор шаблонизатора
$template = new Twig($app);
$app->setTemplater($template);

//Выбор роутинга
$url = parse_url($_SERVER["REQUEST_URI"]);
$path = $url['path'];
$router = new Router($app);
$app->setRouter($router);
$app->getRouter()->runAction($path);
*/

$app->run();