<?php

namespace src\Controllers\App;

use src\Controllers\MainController;
use src\Models\Category;
use src\Controllers\App\Component\TopMenuComponent;

class CategoryController extends MainController {

    public function indexAction() {

        $catTbl = new Category($this->getApp());
        $categories = $catTbl->getAllThisLevelCategories();

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        $this->render(array(
            'categories' => $categories,
            'leftMenu' => $componentMenuResp,
        ), 'App/Category/index.html');

    }

    public function categoryAction() {

        $catId = (int) $this->getRequestParam('id', 0);

        $catTbl = new Category($this->getApp());
        $categories = $catTbl->getAllThisLevelCategories($catId);

        $catTbl = new Category($this->getApp());
        $products = $catTbl->getProductsFromCategory($catId);

        if (!$products) {
            $this->notFound();
        }

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        $this->render(array(
            'categories' => $categories,
            'products' => $products,
            'leftMenu' => $componentMenuResp,
        ), 'App/Category/products.html');

    }

} 