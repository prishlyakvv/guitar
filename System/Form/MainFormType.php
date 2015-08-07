<?php

namespace System\Form;

use System\Form\Validator\MainValidator;
use System\Model\MainModel;

class MainFormType {

    /**
     * @var MainForm
     */
    protected $_form;


    /**
     * @var \System\App
     */
    private $_app;

    /**
     * @var \System\Controller\MainController
     */
    private $_controller;

    /**
     * @var array
     */
    protected $_errors = array();

    /**
     * @var MainValidator
     */
    protected $_validator;

    /**
     * @var MainModel;
     */
    protected $_dataClass;

    /**
     * @var array
     */
    protected $_data = array();

    /**
     * @param $app
     * @param $controller
     */
    public function __construct($app, $controller) {
        $this->_app = $app;
        $this->_controller = $controller;
        $this->_validator = new MainValidator();
        $form = new MainForm($this->_app);
        $this->_form = $this->make($form);
        $this->setDefaults();
        $this->fixPKField($form);
    }

    /**
     * @param MainForm $form
     * @return MainForm
     */
    protected function make(MainForm $form) {

        return $form;

    }

    /**
     * Дополнительные параметры
     * применяется в дочерних классах
     */
    protected function setDefaults() {

    }

    protected function fixPKField(MainForm $form) {

        if ($this->getDataClass()) {
            $form->addHidden($this->getDataClass()->getPk(), '');
        }

    }

    /**
     * @param $data
     * @return $this
     */
    public function fill($data) {

        /**
         * reset data for new fill
         */
        $this->setData(array());

        foreach($this->_form->getElements() as &$element) {
            $elName = $element->getName();
            if (isset($data[$elName])) {
                $element->setValue($data[$elName]);
                $this->addData($elName, $data[$elName]);
            }
        }

        return $this;

    }

    /**
     * @return bool
     */
    public function isValid() {

        $this->clearErrors();

        foreach($this->_form->getElements() as &$element) {

            if (!method_exists($element, 'getValidateOpt')) {
                continue;
            }

            $htmlTag = $element->getHtmlTag();
            if ($htmlTag != 'input_submit') {
                $elName = $element->getName();
                $elLabel = (method_exists($element, 'getLabel')) ? $element->getLabel() : '';
                $elValue = $element->getValue();
                $elParamsValidate = $element->getValidateOpt();

                if (isset($data[$elName])) {
                    $element->setValue($data[$elName]);
                }

                $errorEl = array();
                foreach ($elParamsValidate as $type => $optValidate) {
                    if (!$this->_validator->validate($elValue, $type, $optValidate)) {
                        $text = $elLabel . ' - ' . $this->_validator->getError();
                        $this->addError($text);
                        $errorEl[] = $text;
                    }
                }

                if ($errorEl) {
                    $element->setError(implode('<br>', $errorEl));
                }
            }

        }

        return !$this->_errors;

    }


    public function fillAndIsValid() {

        $data = $this->_controller->getRequestAll();
        $this->fill($data);
        return $this->isValid();

    }

    /**
     * @return \System\App
     */
    public function getApp()
    {
        return $this->_app;
    }

    /**
     * @return string
     */
    public function render() {

        return $this->_form->render();

    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * @param $error
     */
    public function addError($error)
    {
        $this->_errors[] = $error;
    }

    /**
     *
     */
    public function clearErrors()
    {
        $this->_errors = array();
    }

    /**
     * @return \System\Form\Validator\MainValidator
     */
    public function getValidator()
    {
        return $this->_validator;
    }

    /**
     * @param \System\Form\Validator\MainValidator $validator
     */
    public function setValidator($validator)
    {
        $this->_validator = $validator;
    }

    /**
     * @return \System\Model\MainModel
     */
    public function getDataClass()
    {
        return $this->_dataClass;
    }

    /**
     * @param \System\Model\MainModel $dataClass
     */
    public function setDataClass($dataClass)
    {
        $this->_dataClass = $dataClass;
    }

    public function save() {
        if (!$this->isValid() || !$this->getDataClass() || !$this->getData()) {
            throw new \Exception('Для сохранения данных в бд форма должна быть валидной, заполненой и нужно указать класс данных');
        }

        $class = $this->getDataClass();
        $columns = $class->getColumns();
        $data = $this->getData();
        $pk = $class->getPk();

        if (!isset($columns[$pk])) {
            throw new \Exception('Указанный PRIMARY KEY отсутствует в списке getColumns модели');
        }

        $new = !(isset($data[$pk]) && $data[$pk]);

        $modelFill = array();
        foreach ($columns as $colName => $colAtrr) {
            $val = (isset($data[$colName])) ? $data[$colName] : null;
            $modelFill[$colName] = $val;
        }

        $return = false;
        if ($modelFill) {
            if ($new) {
                $return = $class->insert($modelFill);
            } else {
                $return = $class->update($modelFill, array('id'=> (int)$data[$pk]));
            }
        }

       return $return;

    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addData($key, $value)
    {
        $this->_data[$key] = $value;
    }

} 