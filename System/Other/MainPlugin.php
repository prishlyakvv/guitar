<?php

namespace System\Other;

use System\Other\Lib\YmlParser;

abstract class MainPlugin {

    protected function getConfiguration() {

        $parser = new YmlParser();
        return $parser->parse('Plugins/Store/Others/Config/app.yml');

    }

    protected function getRoutes() {

        $parser = new YmlParser();
        return $parser->parse('Plugins/Store/Others/Routes/routes.yml');

    }

    abstract function init();


}

