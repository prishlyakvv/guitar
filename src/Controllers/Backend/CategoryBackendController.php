<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\TopMenuComponent;
use src\Models\Category;

class CategoryBackendController extends MainBackendController {

    public function indexAction() {

        $component = new TopMenuComponent($this);
        $componentResp = $component->toString();

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


        $this->render(array(
            'component' => $componentResp,
            'categories' => $cats,
        ), 'Backend/Category/index.html');

    }

} 