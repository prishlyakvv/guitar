<?php

namespace Plugins\Store\Controllers\App\Component;

use System\Controller\MainComponent;
use Plugins\Store\Models\Category;

class TopMenuComponent extends MainComponent {

    protected function initialize() {

    }

    protected function run() {

        $catTbl = new Category();
        $categories = $catTbl->getAllThisLevelCategories();

        return $this->render(array(
            'categories' => $categories,
        ), 'App/Component/topMenuComponent.html');

    }


} 