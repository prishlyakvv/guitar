<?php

namespace src\Controllers\App\Component;

use System\Controller\MainComponent;
use src\Models\Category;

class TopMenuComponent extends MainComponent {

    protected function initialize() {

    }

    protected function run() {

        $catTbl = new Category($this->getApp());
        $categories = $catTbl->getAllThisLevelCategories();

        return $this->render(array(
            'categories' => $categories,
        ), 'App/Component/topMenuComponent.html');

    }


} 