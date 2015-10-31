<?php

namespace src\Controllers\Backend;

use src\Controllers\MainController;
use System\App;


class MainBackendController extends MainController {

    public function __construct() {
        parent::__construct();

        $this->checkAuthorizate();
    }

    protected function checkAuthorizate() {
        $sess = App::getInstance()->getSession();
        if (!$sess->getByName('login_id') || !$sess->getByName('login_name')) {
            $router = App::getInstance()->getRouter();
            if ($router->getCurrentPath() != $router->getPathByName('backend_index')) {
                $this->redirect('backend_index');
            }
        }
    }

} 