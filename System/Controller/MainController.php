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

    public function __construct($app) {
        $this->_app = $app;
        $this->prepareRequest();
    }

    public function getApp() {
        return $this->_app;
    }

    protected function prepareRequest() {

        foreach ($_REQUEST as $key => $val) {
            $val = htmlspecialchars($val);
            $this->_request[$key] = $val;
        }

    }

    public function getRequestAll() {

        return $this->_request;

    }

    public function getRequestParam($param, $default = false) {

        return (isset($this->_request[$param])) ? $this->_request[$param] : $default;

    }

} 