<?php

namespace System\Router;

use System\Controller\MainController;
use System\Lib\YmlParser;

class Router extends MainRouter implements RouterInterface {


    /**
     * @var array
     */
    private $_routes = array();

    private $_url = '';

    /**
     * Запуск екшена роута
     *
     * @param $url
     * @throws \Exception
     */
    public function runAction($url) {

        $this->_url = $url;

        $this->getController($url);

        $controllerPath = $this->_controller['controller'];
        $controllerPathArr = explode(':',$controllerPath);
        $classController = $controllerPathArr[0];
        $actionController = $controllerPathArr[1];

        if (!method_exists($classController, $actionController)) {
            throw new \Exception('Отсутствует класс или екшен (' . $classController . '->' . $actionController . ')');
        }

        $controller = new $classController();
        $controller->$actionController();

    }

    /**
     * Загружает роуты из конфига
     */
    protected function loadRoutes() {

        $parser = new YmlParser();
        $this->_routes = $parser->parse('System/Router/routes.yml');

    }

    public function setRoutes($routes) {
        $this->_routes = $routes;
    }

    public function getRoutes() {
        return $this->_routes;
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
            $this->_controller = new MainController();
            $this->_controller->notFound();
        }

    }

    /**
     * @param $name
     * @param array $params
     * @throws \Exception
     * @return mixed
     */
    public function getPathByName($name, $params = array()) {

        if (isset($this->_routes[$name]) && isset($this->_routes[$name]['path'])) {

            $path = $this->_routes[$name]['path'];
            if ($params) {
                if (is_array($params)) {
                    $paramsTmp = $params;
                    $params = '';
                    $num = 0;
                    $count = count($paramsTmp);
                    foreach ($paramsTmp as $key => $param) {
                        $num++;
                        $params .= $key . '=' . $param;
                        if ($count > $num) {
                            $params .= "& ";
                        }

                    }
                }
                $path = $path . '?' . $params;
            }

            return $path;
        }

        throw new \Exception('Неверное имя роута');

    }


    public function getCurrentPath() {

        return $this->_url;

    }

}
