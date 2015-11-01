<?php

namespace Plugins\Store\Controllers\App;

use Plugins\Store\Controllers\MainController;
use Plugins\Store\Models\Product;
use Plugins\Store\Controllers\App\Component\TopMenuComponent;
use System\App;

class ProductController extends MainController {

    public function indexAction() {

        $prodId = (int) $this->getRequestParam('id', 0);

        $prodTbl = new Product();
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