<?php

namespace System;

use System\Router\Router;
use System\Services\Session;
use System\Template\TemplateInterface;
use System\Router\RouterInterface;
use System\Template\Twig;
use System\Lib\YmlParser;

final class App {

    /**
     * @var Template\Twig
     */
    protected $_templater;

    /**
     * @var Router
     */
    protected $_router;

    protected $_url;

    protected $_config = array();

    /**
     * Флаг использования на прод.-сервере
     * @var bool
     */
    protected $_prod = false;

    protected $_response = '';

    /**
     * @var Services\Session
     */
    protected $_session;

    public function __construct() {
        $this->_session = new Session($this);
        $this->_templater = new Twig($this);
        $this->_router = new Router($this);
        $this->loadConfig();
    }

    /**
     * @param TemplateInterface $templater
     */
    public function setTemplater(TemplateInterface $templater){
        $this->_templater = $templater;
    }

    /**
     * @return Twig
     */
    public function getTemplater(){
        return $this->_templater;
    }

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router){
        $this->_router = $router;
    }

    /**
     * @return Router
     */
    public function getRouter(){
        return $this->_router;
    }

    /**
     * @return bool
     */
    public function isProd() {
        return $this->_prod;
    }

    /**
     * @param bool $flag
     */
    public function setProd($flag = true) {
        $this->_prod = $flag;
    }

    /**
     * Точка запуска приложения
     */
    public function run(){
        $url = parse_url($_SERVER["REQUEST_URI"]);
        $path = $url['path'];
        $this->_router->runAction($path);

        echo $this->getResponse();
    }

    public function loadConfig() {

        $parser = new YmlParser();
        $this->_config = $parser->parse('config/app.yml');

    }

    public function getConfigParam($param) {

        if (isset($this->_config[$param])) {
            return $this->_config[$param];
        }

        throw new \Exception('Отсутствует параметр в конфиге');

    }

    /**
     * @return string
     */
    public function getResponse() {

        return $this->_response;

    }

    /**
     * @param $response
     */
    public function setResponse($response) {

        $this->_response = $response;

    }

    /**
     * @return Session
     */
    public function getSession() {
        return $this->_session;
    }

}

