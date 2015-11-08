<?php

namespace Plugins\Store\Controllers\Backend\Controller;

use Plugins\Store\Controllers\Backend\Component\TopMenuComponent;
use Plugins\Store\Models\Category;
use Plugins\Store\Controllers\Backend\Component\NotifyComponent;
use Plugins\Store\Others\Form\CategoryFormType;

class CategoryBackendController extends MainBackendController {

    public function indexAction() {

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        $categoriesTbl = new Category();
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

        $categoriesTbl = new Category();
        $cat = $categoriesTbl->getCategory($catId);

        if (!$cat) {
            $this->notFound();
        }

        $componentMenu = new TopMenuComponent($this);
        $componentMenuResp = $componentMenu->toString();

        $componentNotify = new NotifyComponent($this);
        $componentNotifyResp = $componentNotify->toString();

        $form = new CategoryFormType($this);

        $form->fill($cat);
        if ($_POST) {
            if ($form->fillAndIsValid()) {
                if ($idNew = $form->save()) {
                    if (is_array($idNew)) {
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