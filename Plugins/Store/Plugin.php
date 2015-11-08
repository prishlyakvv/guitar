<?php

namespace Plugins\Store;

use Plugins\Store\Others\Console\Console;
use System\Other\MainPlugin;


class Plugin extends MainPlugin {

    protected $name = 'Store';

    public function init() {

        return (array(
            'configuration' => $this->getConfiguration(),
            'routes' => $this->getRoutes(),
        ));

    }

    public function getConsole() {
        return new Console();
    }

} 