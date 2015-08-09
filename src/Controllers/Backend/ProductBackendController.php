<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\TopMenuComponent;
use src\Models\Product;
use src\Controllers\Backend\Component\NotifyComponent;
use src\Form\ProductFormType;
use System\Form\MainFilter;

class ProductBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

        $productTbl = new Product($this->getApp());

        if ($_POST && isset($_POST['remove'])) {
            if ($productTbl->removeProducts($_POST['remove'])) {
                $this->addNotify('Успешно удалено');
            } else {
                $this->addNotify('Удаление не выполнено');
            }
            $this->redirect('backend_products');
        }

        $filter = new MainFilter($this->getApp(), $this);
        $data = array(
            array('id' => 'ALL', 'name' => 'Все статусы'),
            array('id' => 1, 'name' => 'Видимые'),
            array('id' => 0, 'name' => 'Скрытые'),
        );
        $filter->addFSelect('visible', 'Видимость', $data);

        $products = $productTbl->getAllProducts($filter->getData());

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $this->render(array(
            'filterR' => $filter->render(),
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