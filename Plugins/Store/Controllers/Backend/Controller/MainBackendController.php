<?php

namespace Plugins\Store\Controllers\Backend\Controller;

use System\Controller\MainController as BaseMainController;
use System\App;


class MainBackendController extends BaseMainController {

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

    public function notFound() {

        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");

        $url = htmlentities('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], ENT_QUOTES);

        echo $this->render(array(
            'url' => $url,
        ), 'notFound.html');

        exit();
    }

} 