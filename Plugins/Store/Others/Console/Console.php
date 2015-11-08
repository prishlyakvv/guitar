<?php

namespace Plugins\Store\Others\Console;

use Plugins\Store\Models\Product;
use System\Other\Console\MainPluginConsole;
use Plugins\Store\Models\Category;

class Console extends MainPluginConsole {

    const CONSOLE_SHOW_CATEGORIES = 'showCategories';
    const CONSOLE_SHOW_PRODUCTS = 'showProducts';

    public function showCategories() {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories(10);

        var_dump($categories); die;
    }

    public function showCategories_Help() {
        return 'Просмотр категорий товаров (10 шт.)';
    }


    public function showProducts() {
        $productModel = new Product();
        $products = $productModel->getAllProducts(array(), 10);

        var_dump($products); die;
    }

    public function showProducts_Help() {
        return 'Просмотр товаров (20 шт.)';
    }

} 