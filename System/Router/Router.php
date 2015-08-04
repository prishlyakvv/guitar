<?php

namespace System\Router;

use src\Controllers\MainController;
use System\Lib\YmlParser;

class Router extends MainRouter implements RouterInterface {


    /**
     * @var array
     */
    private $_routes = array();

    /**
     * Запуск екшена роута
     *
     * @param $url
     * @throws \Exception
     */
    public function runAction($url) {

        $this->getController($url);

        $controllerPath = $this->_controller['controller'];
        $controllerPathArr = explode(':',$controllerPath);
        $classController = $controllerPathArr[0];
        $actionController = $controllerPathArr[1];

        if (!method_exists($classController, $actionController)) {
            throw new \Exception('Отсутствует класс или екшен (' . $classController . '->' . $actionController . ')');
        }

        $controller = new $classController($this->getApp());
        $controller->$actionController();

    }

    /**
     * Загружает роуты из конфига
     */
    protected function loadRoutes() {

        $parser = new YmlParser();
        $this->_routes = $parser->parse('System/Router/routes.yml');

    }

    /**
     * Получаем контроллер из роута
     *
     * @param $url
     * @throws \Exception
     */
    protected function getController($url) {

        foreach ($this->_routes as $route) {

            if ($route['path'] == $url) {
                $this->_controller = $route;
            }
        }

        if (!$this->_controller) {
            $this->_controller = new MainController($this->getApp());
            $this->_controller->notFound();
        }

    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function getPathByName($name) {

        if (isset($this->_routes[$name]) && isset($this->_routes[$name]['path'])) {
            return $this->_routes[$name]['path'];
        }

        throw new \Exception('Неверное имя роута');

    }

}
