<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\TopMenuComponent;
use src\Models\Category;
use src\Controllers\Backend\Component\NotifyComponent;
use src\Form\CategoryFormType;

class CategoryBackendController extends MainBackendController {

    public function indexAction() {

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        $categoriesTbl = new Category($this->getApp());
        $cats = $categoriesTbl->getAllCategories();

        if ($_POST && isset($_POST['remove'])) {
            if ($categoriesTbl->removeCategories($_POST['remove'])) {
                $this->addNotify('Успешно удалено');
            } else {
                $this->addNotify('Удаление не выполнено');
            }
            $this->redirect('backend_categories');
        }

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $this->render(array(
            'componentMenu' => $componentMenuResp,
            'componentNotify' => $componentNotifyResp,
            'categories' => $cats,
        ), 'Backend/Category/index.html');

    }

    public function categoryAction() {

        $catId = (int) $this->getRequestParam('id', 0);

        $categoriesTbl = new Category($this->getApp());
        $cat = $categoriesTbl->getCategory($catId);

        if (!$cat) {
            $this->notFound();
        }

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        if ($_POST && isset($_POST['remove'])) {
            if ($categoriesTbl->removeCategories($_POST['remove'])) {
                $this->addNotify('Успешно удалено');
            } else {
                $this->addNotify('Удаление не выполнено');
            }
            $this->redirect('backend_categories');
        }

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $form = new CategoryFormType($this->getApp(), $this);

        $form->fill($cat);
        if ($_POST) {
            if ($form->fillAndIsValid()) {
                if ($idNew = $form->save()) {
                    if ($idNew === true) {
                        $idNew = $catId;
                    }
                    $this->redirect('backend_category', array('id'=>$idNew));
                }
            }
        }

        $formR = $form->render();

        $this->render(array(
            'componentMenu' => $componentMenuResp,
            'componentNotify' => $componentNotifyResp,
            'form' => $formR,
        ), 'Backend/Category/category.html');

    }

} 