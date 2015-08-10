<?php

namespace src\Controllers\App;

use src\Controllers\MainController;
use src\Models\Category;
use src\Controllers\App\Component\TopMenuComponent;
use System\Controller\Component\PaginatorComponent;

class CategoryController extends MainController {

    public function indexAction() {

        $paginator = new PaginatorComponent($this);
        $catTbl = new Category($this->getApp());
        $countCategories = $catTbl->getCountAllThisLevelCategories();
        $paginator->setCount($countCategories);
        $paginatorResp = $paginator->toString();

        $categories = $catTbl->getAllThisLevelCategories(0, $paginator->getFrom(), $paginator->getCurrLimit());

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        $this->render(array(
            'categories' => $categories,
            'paginatorR' => $paginatorResp,
            'leftMenu' => $componentMenuResp,
        ), 'App/Category/index.html');

    }

    public function categoryAction() {

        $catId = (int) $this->getRequestParam('id', 0);

        $catTbl = new Category($this->getApp());
        $category = $catTbl->getCategory($catId);

        if (!$category) {
            $this->notFound();
        }

        $categories = $catTbl->getAllThisLevelCategories($catId);
        $products = $catTbl->getProductsFromCategory($catId);

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        $this->render(array(
            'category' => $category,
            'categories' => $categories,
            'products' => $products,
            'leftMenu' => $componentMenuResp,
        ), 'App/Category/products.html');

    }

} 