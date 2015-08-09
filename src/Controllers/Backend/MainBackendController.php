<?php

namespace src\Controllers\Backend;

use src\Controllers\MainController;


class MainBackendController extends MainController {

    public function __construct($app) {
        parent::__construct($app);

        $this->checkAuthorizate();
    }

    protected function checkAuthorizate() {
        $sess = $this->getApp()->getSession();
        if (!$sess->getByName('login_id') || !$sess->getByName('login_name')) {
            $router = $this->getApp()->getRouter();
            if ($router->getCurrentPath() != $router->getPathByName('backend_index')) {
                $this->redirect('backend_index');
            }
        }
    }

} 