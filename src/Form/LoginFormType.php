<?php

namespace src\Form;


use System\Form\MainFormType;
use System\Form\MainForm;
use System\Form\Validator\MainValidator;
use src\Models\Category;

class LoginFormType extends MainFormType {

    protected function make(MainForm $form) {

        $form->setName('login');
        $form->setMethod(MainForm::METHOD_POST);

        $validOpt = array(
            MainValidator::LENGTH_MAX => array(
                'max' => 255,
            ),
        );

        $form->addText('name', 'Имя', '', true, $validOpt);

        $form->addPassword('password', 'Пароль', '', true, $validOpt);

        $form->addSubmit('subm', 'Авторизоваться');

        return $form;

    }

    protected function setDefaults() {
        $this->setDataClass(new Category($this->getApp()));
    }

} 