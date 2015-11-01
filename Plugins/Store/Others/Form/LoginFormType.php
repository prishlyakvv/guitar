<?php

namespace Plugins\Store\Others\Form;


use System\Other\Form\MainFormType;
use System\Other\Form\MainForm;
use System\Other\Form\Validator\MainValidator;
use Plugins\Store\Models\Category;

class LoginFormType extends MainFormType {

    protected function make(MainForm $form) {

        $form->setName('login');
        $form->setMethod(MainForm::METHOD_POST);
        $form->setIsAjax(true);

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
        $this->setDataClass(new Category());
    }

} 