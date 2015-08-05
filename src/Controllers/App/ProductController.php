<?php

namespace src\Controllers\App;

use src\Controllers\MainController;
use src\Models\Product;


class ProductController extends MainController {

    public function indexAction() {

        $prodId = (int) $this->getRequestParam('id', 0);

        $prodTbl = new Product($this->getApp());
        $product = $prodTbl->getProduct($prodId);

        if (!$product) {
            $this->notFound();
        }

        $this->render(array(
            'product' => $product,
        ), 'App/Product/product.html');
    }

} 