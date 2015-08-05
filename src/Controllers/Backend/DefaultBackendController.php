<?php

namespace src\Controllers\Backend;


use src\Controllers\Backend\Component\TopMenuComponent;

class DefaultBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

        $this->render(array(
            'component' => $componentResp,
        ), 'Backend/Default/index.html');

    }

} 