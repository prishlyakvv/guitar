<?php

namespace Plugins\Store;

use System\App;
use System\MainPlugin;


class Main extends MainPlugin {

    public function init() {
        return (array(
            'configuration' => $this->getConfiguration(),
            'routes' => $this->getRoutes(),
        ));

    }


} 