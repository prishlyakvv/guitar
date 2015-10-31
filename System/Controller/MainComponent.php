<?php

namespace System\Controller;

use System\App;


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
     * Если в потомке нужно выполнять какие то действия при инициализации
     * Все эти действия пишем в переопределеном методе
     */
    protected function initialize() {}

    public function toString() {
        return (string) $this->run();
    }

    protected abstract function run();

    /**
     * @param array $data
     * @param $template
     * @return string
     */
    protected function render($data = array(), $template) {
        return App::getInstance()->getTemplater()->render($data, $template);
    }

    /**
     * @return array
     */
    protected function getNotified() {

        return App::getInstance()->getSession()->getNotified();

    }

    /**
     * @param $message
     * @return bool
     */
    protected function addNotify($message) {

        return App::getInstance()->getSession()->addNotify($message);

    }

} 