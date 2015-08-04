<?php

namespace src\Controllers;

use System\Controller\MainController as BaseMainController;


class MainController extends BaseMainController {

    public function notFound() {

        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");

        $url = htmlentities('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], ENT_QUOTES);

        $this->getApp()->getTemplater()->render(array(
            'url' => $url,
        ), 'notFound.html');

        exit();
    }

    /**
     * @param $name
     * @return mixed
     */
    protected function getRoutePathByName($name) {

        return $this->getApp()->getRouter()->getPathByName($name);

    }


} 