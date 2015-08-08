<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\TopMenuComponent;
use src\Models\Product;
use src\Controllers\Backend\Component\NotifyComponent;
use src\Form\ProductFormType;

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


    public function productAction() {

        $prodId = (int) $this->getRequestParam('id', 0);

        $productTbl = new Product($this->getApp());
        $product = $productTbl->getProduct($prodId);

        if (!$product) {
            $this->notFound();
        }

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $form = new ProductFormType($this->getApp(), $this);

        $form->fill($product);
        if ($_POST) {
            if ($form->fillAndIsValid()) {
                if ($idNew = $form->save()) {
                    if (is_array($idNew)) {
                        $idNew = $prodId;
                    }
                    $this->redirect('backend_product', array('id'=>$idNew));
                }
            }
        }

        $formR = $form->render();

        $this->render(array(
            'componentMenu' => $componentMenuResp,
            'componentNotify' => $componentNotifyResp,
            'form' => $formR,
        ), 'Backend/Product/product.html');

    }

} 