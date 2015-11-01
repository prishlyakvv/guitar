<?php

namespace Plugins\Store;

use System\App;
use System\Other\MainPlugin;


class Plugin extends MainPlugin {

    protected $name = 'Store';

    public function init() {

        return (array(
            'configuration' => $this->getConfiguration(),
            'routes' => $this->getRoutes(),
        ));

    }


} 