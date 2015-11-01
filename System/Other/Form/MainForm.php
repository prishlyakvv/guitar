<?php

namespace System\Other\Form;

use System\Other\Form\Fields\File;
use System\Other\Form\Fields\Submit;
use System\Other\Form\Fields\Text;
use System\Other\Form\Fields\Password;
use System\Other\Form\Fields\Textarea;
use System\Other\Form\Fields\Hidden;
use System\Other\Form\Fields\Select;
use System\Other\Form\Fields\Bool;
use System\Other\Form\Validator\MainValidator;
use System\App;

class MainForm {

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    private $_elements = array();
    private $_action = '';
    private $_method = self::METHOD_GET;
    private $_name = 'form_';
    private $_templ = 'Form/form.html';
    private $_multipart = false;
    private $_errors = array();
    private $_formErrors = array();
    private $_isAjax = false;

    /**
     * Форма не должна иметь элименты с одним name
     *
     * @param $name
     * @throws \Exception
     */
    protected function checkName($name) {

        foreach($this->_elements as $element) {

            if ($element->getName() == $name) {
                throw new \Exception('Повторяющееся имя для элемента формы');
            }

        }

    }


    /**
     * @param $name
     * @param $label
     * @param $value
     * @param $require
     * @param $paramValidate
     * @return $this
     */
    public function addText($name, $label, $value, $require, $paramValidate) {

        $this->checkName($name);

        $el = new Text();
        $el->setName($name);
        $el->setLabel($label);
        $el->setValue($value);
        $el->setRequire($require);
        $el->setValidateOpts($paramValidate);

        $this->addElement($el);

        return $this;

    }

    /**
     * @param $name
     * @param $label
     * @param $value
     * @param $require
     * @param $paramValidate
     * @return $this
     */
    public function addPassword($name, $label, $value, $require, $paramValidate) {

        $this->checkName($name);

        $el = new Password();
        $el->setName($name);
        $el->setLabel($label);
        $el->setValue($value);
        $el->setRequire($require);
        $el->setValidateOpts($paramValidate);

        $this->addElement($el);

        return $this;

    }

    /**
     * @param $name
     * @param $label
     * @param $value
     * @param $require
     * @return $this
     */
    public function addFile($name, $label, $value, $require) {

        $this->checkName($name);

        $el = new File();
        $el->setName($name);
        $el->setLabel($label);
        $el->setValue($value);
        $el->setRequire($require);

        $this->addElement($el);
        $this->setMultipart(true);

        return $this;

    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addHidden($name, $value) {

        $this->checkName($name);

        $el = new Hidden();
        $el->setName($name);
        $el->setValue($value);

        $this->addElement($el);

        return $this;

    }

    /**
     * @param $name
     * @param $label
     * @param $value
     * @param $require
     * @param $paramValidate
     * @return $this
     */
    public function addTextarea($name, $label, $value, $require, $paramValidate) {

        $this->checkName($name);

        $el = new Textarea();
        $el->setName($name);
        $el->setLabel($label);
        $el->setValue($value);
        $el->setRequire($require);
        $el->setValidateOpts($paramValidate);

        $this->addElement($el);

        return $this;

    }

    /**
     * @param $name
     * @param $label
     * @param $value
     * @param $data
     * @return $this
     */
    public function addSelect($name, $label, $value, $data) {

        $this->checkName($name);

        $el = new Select();
        $el->setName($name);
        $el->setLabel($label);
        $el->setValue($value);
        $el->setData($data);

        $this->addElement($el);

        return $this;

    }

    /**
     * @param $name
     * @param $label
     * @param $value
     * @return $this
     */
    public function addBool($name, $label, $value) {

        $this->checkName($name);

        $el = new Bool();
        $el->setName($name);
        $el->setLabel($label);
        $el->setValue($value);

        $this->addElement($el);

        return $this;

    }


    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addSubmit($name, $value) {

        $this->checkName($name);

        $el = new Submit();

        $el->setName($name);
        $el->setValue($value);

        $this->addElement($el);

        return $this;

    }

    /**
     * @return string
     */
    public function render() {

        $data = array(
            'action' => $this->getAction(),
            'method' => $this->getMethod(),
            'name' => $this->getName(),
            'fields' => $this->getElements(),
            'multipart' => $this->getMultipart(),
            'errors' => $this->getErrors(),
            'formErrors' => $this->getFormErrors(),
            'isAjax' => $this->getIsAjax(),
        );

        $res = $this->renderTmpl($data, $this->getTempl());

        return $res;

    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->_action = $action;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->_method = $method;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @param array $data
     * @param $template
     * @return string
     */
    protected function renderTmpl($data = array(), $template) {

        return App::getInstance()->getTemplater()->render($data, $template);

    }

    /**
     * @return string
     */
    public function getTempl()
    {
        return $this->_templ;
    }

    /**
     * @param string $templ
     */
    public function setTempl($templ)
    {
        $this->_templ = $templ;
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->_elements;
    }

    /**
     * @param $element \System\Other\Form\Fields\MainField
     */
    public function addElement($element)
    {
        if (method_exists($element,'getRequire') && $element->getRequire() && method_exists($element,'addValidateOpt')) {
            $element->addValidateOpt(MainValidator::NOT_EMPTY, true);
        }
        $this->_elements[] = $element;
    }

    /**
     * @return boolean
     */
    public function getMultipart()
    {
        return $this->_multipart;
    }

    /**
     * @param boolean $multipart
     */
    public function setMultipart($multipart)
    {
        $this->_multipart = $multipart;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->_errors = $errors;
    }

    /**
     * @return boolean
     */
    public function getIsAjax()
    {
        return $this->_isAjax;
    }

    /**
     * @param boolean $isAjax
     */
    public function setIsAjax($isAjax)
    {
        $this->_isAjax = $isAjax;
    }

    /**
     * @return array
     */
    public function getFormErrors()
    {
        return $this->_formErrors;
    }

    /**
     * @param array $formErrors
     */
    public function setFormErrors($formErrors)
    {
        $this->_formErrors = $formErrors;
    }

} 