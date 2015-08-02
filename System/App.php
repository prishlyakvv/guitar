<?php

namespace System;

use System\Router\Router;
use System\Template\TemplateInterface;
use System\Router\RouterInterface;
use System\Template\Twig;

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

    /**
     * Флаг использования на прод.-сервере
     * @var bool
     */
    protected $_prod = false;

    public function __construct() {
        $this->_templater = new Twig($this);
        $this->_router = new Router($this);
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
    }


}

