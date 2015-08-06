<?php

namespace System\Form;

use System\Form\Validator\MainValidator;

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
     * @param $app
     * @param $controller
     */
    public function __construct($app, $controller) {
        $this->_app = $app;
        $this->_controller = $controller;
        $this->_validator = new MainValidator();
        $form = new MainForm($this->_app);
        $this->_form = $this->make($form);
    }

    /**
     * @param MainForm $form
     * @return MainForm
     */
    protected function make(MainForm $form) {

        return $form;

    }

    public function fill($data) {

        foreach($this->_form->getElements() as &$element) {
            $elName = $element->getName();
            if (isset($data[$elName])) {
                $element->setValue($data[$elName]);
            }
        }

        return true;

    }

    public function isValid() {

        $this->clearErrors();

        foreach($this->_form->getElements() as &$element) {

            $htmlTag = $element->getHtmlTag();
            if ($htmlTag != 'input_submit') {
                $elName = $element->getName();
                $elLabel = $element->getLabel();
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


        return (bool) $this->_errors;

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

} 