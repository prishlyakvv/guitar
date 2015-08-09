<?php

namespace System\Controller;


class MainController {

    /**
     * @var \System\App
     */
    private  $_app;

    /**
     * Можно было бы вынести в отдельный клас
     * и сделать слабую связанность.
     *
     * @var array
     */
    protected $_request = array();

    /**
     * @param $app
     */
    public function __construct($app) {
        $this->_app = $app;
        $this->prepareRequest();
    }

    /**
     * @return \System\App
     */
    public function getApp() {
        return $this->_app;
    }

    /**
     * Действия с передаваемыми значениями
     */
    protected function prepareRequest() {

        foreach ($_REQUEST as $key => $val) {
            if (is_string($val)) {
                //todo Поправить
                $val = htmlspecialchars($val);
                $this->_request[$key] = $val;
            }
        }

    }

    /**
     * @return array
     */
    public function getRequestAll() {

        return $this->_request;

    }

    /**
     * @param $param
     * @param bool $default
     * @return bool
     */
    public function getRequestParam($param, $default = false) {

        return (isset($this->_request[$param])) ? $this->_request[$param] : $default;

    }

    /**
     * @param array $data
     * @param $template
     * @return string
     */
    protected function render($data = array(), $template) {

        return $this->getApp()->getTemplater()->render($data, $template);

    }

    /**
     * @return array
     */
    protected function getNotified() {

        return $this->getApp()->getSession()->getNotified();

    }

    /**
     * @param $message
     * @return bool
     */
    protected function addNotify($message) {

        return $this->getApp()->getSession()->addNotify($message);

    }


    /**
     * @param $name
     * @param array $params
     */
    protected function redirect($name, $params = array()) {

        $path = $this->getApp()->getRouter()->getPathByName($name, $params);
        http_redirect($path);

    }

} 