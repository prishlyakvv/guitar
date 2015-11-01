<?php

namespace Plugins\Store\Controllers\Backend;

use Plugins\Store\Controllers\Backend\Component\TopMenuComponent;
use Plugins\Store\Models\Product;
use Plugins\Store\Controllers\Backend\Component\NotifyComponent;
use Plugins\Store\Others\Form\ProductFormType;
use System\Other\Form\MainFilter;

class ProductBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

        $productTbl = new Product();

        if ($_POST && isset($_POST['remove'])) {
            if ($productTbl->removeProducts($_POST['remove'])) {
                $this->addNotify('Успешно удалено');
            } else {
                $this->addNotify('Удаление не выполнено');
            }
            $this->redirect('backend_products');
        }

        $filter = new MainFilter($this);
        $data = array(
            array('id' => 0, 'name' => 'Все статусы'),
            array('id' => 'visible', 'name' => 'Видимые'),
            array('id' => 'hidden', 'name' => 'Скрытые'),
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

        $productTbl = new Product();
        $product = $productTbl->getProduct($prodId);

        if (!$product) {
            $this->notFound();
        }

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $form = new ProductFormType($this);

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