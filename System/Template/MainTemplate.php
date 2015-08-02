<?php

namespace System\Template;

abstract Class MainTemplate {

    protected $_environment;

    /**
     * @var \System\App
     */
    private $_app;

    public function __construct($app) {
        $this->_app = $app;
        $this->setting();
    }

    public function render($data, $template){}

    protected  function setting(){}

    protected function getApp() {
        return $this->_app;
    }

} 