<?php

namespace System\Other\Router;

abstract class MainRouter {

    protected $_controller;

    public function __construct() {
        $this->loadRoutes();
    }

    public function runAction($url) {}

    protected abstract function loadRoutes();

    protected abstract function getController($url);

}