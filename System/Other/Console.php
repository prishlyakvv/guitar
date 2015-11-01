<?php

namespace System\Other;

final class Console {

    private $_args = array();

    public function setArgs($args) {
        $this->_args = $args;
    }

    public function run() {
        var_dump($this->_args);
    }

}

