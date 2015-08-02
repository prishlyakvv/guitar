<?php

namespace System\Router;

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
     */
    public function runAction($url) {

        $this->getController($url);

        $controllerPath = $this->_controller['controller'];
        $controllerPathArr = explode(':',$controllerPath);
        $classController = $controllerPathArr[0];
        $actionController = $controllerPathArr[1];

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
            throw new \Exception('Не определен Url');
        }

    }

}
