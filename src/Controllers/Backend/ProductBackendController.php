<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\TopMenuComponent;
use src\Models\Product;

class ProductBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

        $productTbl = new Product($this->getApp());
        $products = $productTbl->getAllProducts();

        $this->render(array(
            'component' => $componentResp,
            'products' => $products,
        ), 'Backend/Product/index.html');

    }

} 