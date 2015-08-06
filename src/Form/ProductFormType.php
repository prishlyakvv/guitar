<?php

namespace src\Form;


use System\Form\MainFormType;
use System\Form\MainForm;
use System\Form\Validator\MainValidator;

class ProductFormType extends MainFormType {

    protected function make(MainForm $form) {

        $form->setName('product');
        $form->setMethod(MainForm::METHOD_POST);

        $validOpt = array(
            MainValidator::NOT_EMPTY => array(
                'message' => 'Заполните название',
            ),
            MainValidator::LENGTH_MIN => array(
                'message' => 'Название не должно быть таким маленьким)',
                'min' => 5,
            ),
            MainValidator::LENGTH_MAX => array(
                'message' => 'Слишком большое название',
                'max' => 20,
            ),
        );

        $form->addText('name', 'Название', '', true, $validOpt);

        $form->addText('file', 'Файл', '', true, array());

        $form->addSubmit('pr_s', 'Отправить');

        return $form;

    }

} 