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

        $form->addFile('file', 'Изображение', '', true);

        $tblCat = new Category($this->getApp());
        $categories = $tblCat->getAllCategoriesForFilter();
        $form->addSelect('parent_category', 'Родительская категория', '0', $categories);

        $form->addText('number_sort', 'Порядок сортировки', '0', true, array());

        $form->addSubmit('pr_s', 'Отправить');

        return $form;

    }

    protected function setDefaults() {
        $this->setDataClass(new Category($this->getApp()));
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
            $configTwigUpload = $this->getApp()->getConfigParam('upload_files');
            if (!isset($configTwigUpload['images_category_and_product'])) {
                throw new \Exception('Неверные Параметры конфигурации upload_files');
            }
            $prefix = $configTwigUpload['images_category_and_product'] . '/category/';
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

        $configTwigUpload = $this->getApp()->getConfigParam('upload_files');
        if (!isset($configTwigUpload['images_category_and_product'])) {
            throw new \Exception('Неверные Параметры конфигурации upload_files');
        }

        $id = (int) $data['id'];
        $file = $this->getApp()->getCurrDir() . '/web' . $configTwigUpload['images_category_and_product'] . '/category/' . $id . '.*';

        array_map('unlink', glob($file));

    }

} 