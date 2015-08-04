<?php

namespace src\Controllers\App;

use src\Controllers\MainController;
use src\Models\Category;
use src\Models\Product;


class CategoryController extends MainController {

    public function indexAction() {

        $catTbl = new Category($this->getApp());
        $categories = $catTbl->getAllCategories();

        $this->getApp()->getTemplater()->render(array(
            'categories' => $categories,
        ), 'App/Category/index.html');

    }

    public function categoryAction() {

        $catId = (int) $this->getRequestParam('id', 0);

        $catTbl = new Category($this->getApp());
        $products = $catTbl->getProductsFromCategory($catId);

        if (!$products) {
            $this->notFound();
        }

        $this->getApp()->getTemplater()->render(array(
            'products' => $products,
        ), 'App/Category/products.html');

    }

} 