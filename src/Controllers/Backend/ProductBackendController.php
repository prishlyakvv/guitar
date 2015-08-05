<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\TopMenuComponent;
use src\Models\Product;
use src\Controllers\Backend\Component\NotifyComponent;

class ProductBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

        $productTbl = new Product($this->getApp());
        $products = $productTbl->getAllProducts();

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $this->render(array(
            'componentMenu' => $componentResp,
            'products' => $products,
            'componentNotify' => $componentNotifyResp,
        ), 'Backend/Product/index.html');

    }

} 