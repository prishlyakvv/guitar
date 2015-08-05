<?php

namespace src\Controllers\Backend;

use src\Controllers\Backend\Component\TopMenuComponent;
use src\Models\Category;
use src\Controllers\Backend\Component\NotifyComponent;
use System\Form\MainForm;

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


        $form = new MainForm($this->getApp());
        $form->addText('dfs', 'dfs', 'dfs', 'dfs', 'dfs');
        $form->addTextarea('dfs2', 'dfs2', 'dfs2', 'dfs2', 'dfs2');
        $form->addSubmit('dfhj', 'dfkhlis');
        $formR = $form->render();

        $this->render(array(
            'componentMenu' => $componentMenuResp,
            'componentNotify' => $componentNotifyResp,
            'form' => $formR,
        ), 'Backend/Category/category.html');

    }

} 