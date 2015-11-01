<?php

namespace Plugins\Store;

use System\App;
use System\Other\MainPlugin;


class Plugin extends MainPlugin {

    public function init() {
        return (array(
            'configuration' => $this->getConfiguration(),
            'routes' => $this->getRoutes(),
        ));

    }


} 