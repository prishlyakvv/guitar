<?php

namespace System\Router;

abstract class MainRouter {

    /**
     * @var \System\App
     */
    private  $_app;

    protected $_controller;

    public function __construct($app) {
        $this->_app = $app;
        $this->loadRoutes();
    }

    public function runAction($url) {}

    protected abstract function loadRoutes();

    protected abstract function getController($url);

    protected function getApp() {
        return $this->_app;
    }
}