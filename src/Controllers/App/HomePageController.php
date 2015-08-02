<?php

namespace src\Controllers\App;

use System\Controller\MainController;
use src\Models\Category;


class HomePageController extends MainController {

    public function indexAction() {

        $catTbl = new Category($this->getApp());
        $categories = $catTbl->getAllCategories();

        $this->getApp()->getTemplater()->render(array(
            'categories' => $categories,
        ), 'index/index.html');

    }

} 