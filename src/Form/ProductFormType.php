<?php

namespace src\Form;


use src\Models\Product;
use System\Form\MainFormType;
use System\Form\MainForm;
use System\Form\Validator\MainValidator;
use src\Models\Category;

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
                'min' => 2,
            ),
            MainValidator::LENGTH_MAX => array(
                'message' => 'Слишком большое название',
                'max' => 255,
            ),
        );

        $form->addText('name', 'Название', '', true, $validOpt);

        $form->addText('price', 'Цена', '', true, array(MainValidator::IS_INTEGER => true));

        $tblCat = new Category($this->getApp());
        $categories = $tblCat->getAllCategoriesForFilter();
        $form->addSelect('category_id', 'Категория', '0', $categories);

        $form->addFile('file', 'Изображение', '', true);

        $form->addBool('visible', 'Видимость', true);

        $form->addBool('isset', 'Наличие', true);

        $form->addTextarea('description', 'Описание', '', true, array(MainValidator::NOT_EMPTY => true));

        $form->addSubmit('pr_s', 'Отправить');

        return $form;

    }

    protected function setDefaults() {
        $this->setDataClass(new Product($this->getApp()));
    }

    /**
     * todo - добавить проверки и исключения
     * todo - вывести пути в конфиги
     *
     * @param $result
     * @throws \Exception
     */
    protected function postSave($result) {

        if (is_array($result)) {
            $data = $this->getData();
            $id = $data['id'];
        } elseif ($result) {
            $id = (int) $result;
        } else {
            $id = 0;
        }


        if (!empty($_FILES['file']['name']) && $id) {
            $prefix = '/img/uploaded/product/';
            $uploaddir = $this->getApp()->getCurrDir() . '/web' . $prefix;
            $info = new \SplFileInfo($_FILES['file']['name']);
            $fileExtension = $info->getExtension();
            $uploadfile = $uploaddir . $id . '.' . $fileExtension;
            $uploadfileDB = $prefix . $id . '.' . $fileExtension;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {

                $tbl = $this->getDataClass();
                $tbl->update(array('file'=>$uploadfileDB), array('id'=>$id));

            } else {

                throw new \Exception('Ошибка при сохранении изображения');

            }

        }
    }


    protected function preSave(&$data) {

        if (isset($_POST['file_old'])) {
            $data['file'] = $_POST['file_old'];
        }

        if (!$data['id'] || empty($_FILES['file']['name']) || !$data['file']) {
            return false;
        }


        $id = (int) $data['id'];
        $file = $this->getApp()->getCurrDir() . '/web/img/uploaded/product/' . $id . '.*';

        array_map('unlink', glob($file));

    }

} 