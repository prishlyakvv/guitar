<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\NotifyComponent;
use src\Controllers\Backend\Component\TopMenuComponent;

class DefaultBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $this->render(array(
            'componentMenu' => $componentResp,
            'componentNotify' => $componentNotifyResp,
        ), 'Backend/Default/index.html');

    }

} 