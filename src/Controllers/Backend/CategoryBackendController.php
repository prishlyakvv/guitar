<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\TopMenuComponent;
use src\Models\Category;

class CategoryBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

        $categoriesTbl = new Category($this->getApp());
        $cats = $categoriesTbl->getAllCategories();

        $this->render(array(
            'component' => $componentResp,
            'categories' => $cats,
        ), 'Backend/Category/index.html');

    }

} 