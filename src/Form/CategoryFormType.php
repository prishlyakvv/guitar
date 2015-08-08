<?php

namespace src\Form;


use System\Form\MainFormType;
use System\Form\MainForm;
use System\Form\Validator\MainValidator;
use src\Models\Category;

class CategoryFormType extends MainFormType {

    protected function make(MainForm $form) {

        $form->setName('product');
        $form->setMethod(MainForm::METHOD_POST);

        $validOpt = array(
            MainValidator::NOT_EMPTY => array(
                'message' => 'Заполните название',
            ),
            MainValidator::LENGTH_MIN => array(
                'message' => 'Название не должно быть таким маленьким)',
                'min' => 2,
            ),
            MainValidator::LENGTH_MAX => array(
                'message' => 'Слишком большое название',
                'max' => 255,
            ),
        );

        $form->addText('name', 'Название', '', true, $validOpt);

        $form->addText('file', 'Файл', '', true, array());

        $tblCat = new Category($this->getApp());
        $categories = $tblCat->getAllCategoriesForFilter();
//        var_dump($categories);die;
        $form->addSelect('parent_category', 'Родительская категория', '0', $categories);

        $form->addText('number_sort', 'Порядок сортировки', '0', true, array());

        $form->addSubmit('pr_s', 'Отправить');

        return $form;

    }

    protected function setDefaults() {
        $this->setDataClass(new Category($this->getApp()));
    }

} 