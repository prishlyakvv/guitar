<?php

namespace System\Template;

abstract Class MainTemplate {

    protected $_environment;

    public function __construct() {
        $this->setting();
    }

    public function render($data, $template){}

    protected  function setting(){}

} 