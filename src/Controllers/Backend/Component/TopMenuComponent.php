<?php

namespace src\Controllers\Backend\Component;

use System\Controller\MainComponent;


class TopMenuComponent extends MainComponent {

    protected function initialize() {

    }

    protected function run() {

        return $this->render(array(), 'Backend/Component/topMenuComponent.html');

    }


} 