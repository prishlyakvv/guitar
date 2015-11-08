<?php

namespace System\Other;

use System\Other\Lib\YmlParser;

abstract class MainPlugin {

    protected $name;

    protected function getConfiguration() {

        $parser = new YmlParser();
        return $parser->parse('Plugins/' . $this->getName() . '/Others/Config/app.yml');

    }

    protected function getRoutes() {

        $parser = new YmlParser();
        return $parser->parse('Plugins/' . $this->getName() . '/Others/Routes/routes.yml');

    }

    abstract function init();

    public function getName() {
        return $this->name;
    }

    public function getConsole() {
        return false;
    }


}

