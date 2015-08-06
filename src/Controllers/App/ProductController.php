<?php

namespace src\Controllers\App;

use src\Controllers\MainController;
use src\Models\Product;
use src\Controllers\App\Component\TopMenuComponent;

class ProductController extends MainController {

    public function indexAction() {

        $prodId = (int) $this->getRequestParam('id', 0);

        $prodTbl = new Product($this->getApp());
        $product = $prodTbl->getProduct($prodId);

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        if (!$product) {
            $this->notFound();
        }

        $this->render(array(
            'product' => $product,
            'leftMenu' => $componentMenuResp,
        ), 'App/Product/product.html');
    }

} 