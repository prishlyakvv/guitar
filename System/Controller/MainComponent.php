<?php

namespace System\Controller;


abstract class MainComponent {

    /**
     * @var MainController
     */
    protected $_controller;

    /**
     * @param $controller
     */
    public function __construct($controller) {
        $this->_controller = $controller;
        $this->initialize();
    }

    /**
     * @return MainController
     */
    protected function getController() {
        return $this->_controller;
    }

    /**
     * @return \System\App
     */
    protected function getApp() {
        return $this->_controller->getApp();
    }

    /**
     * Если в потомке нужно выполнять какие то действия при инициализации
     * Все эти действия пишем в переопределеном методе
     */
    protected function initialize() {}

    public function toString() {
        return (string) $this->run();
    }

    protected abstract function run();

} 