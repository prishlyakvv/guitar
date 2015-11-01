<?php

namespace Plugins\Store\Controllers\Backend\Component;

use System\Controller\MainComponent;


class NotifyComponent extends MainComponent {

    protected function initialize() {

    }

    protected function run() {

        return $this->render(array(
            'notified' => $this->getNotified(),
        ), 'Backend/Component/notifyComponent.html');

    }


} 