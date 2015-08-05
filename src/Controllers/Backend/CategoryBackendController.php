<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\TopMenuComponent;
use src\Models\Category;
use src\Controllers\Backend\Component\NotifyComponent;

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
            'component' => $componentMenuResp,
            'componentNotify' => $componentNotifyResp,
            'categories' => $cats,
        ), 'Backend/Category/index.html');

    }

} 