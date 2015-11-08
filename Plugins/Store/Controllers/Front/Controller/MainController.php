<?php

namespace Plugins\Store\Controllers\Front\Controller;

use System\Controller\MainController as BaseMainController;


class MainController extends BaseMainController {

    public function notFound() {

        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");

        $url = htmlentities('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], ENT_QUOTES);

        echo $this->render(array(
            'url' => $url,
        ), 'notFound.html');

        exit();
    }

} 