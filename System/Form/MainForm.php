<?php

namespace System\Form;

use System\Form\Fields\Submit;
use System\Form\Fields\Text;

class MainForm {

    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    private $_elements = array();
    private $_action = '';
    private $_method = self::METHOD_GET;
    private $_name = 'form_';
    private $_templ = 'Form/form.html';

    /**
     * @var \System\App
     */
    private $_app;

    /**
     * @param $app
     */
    public function __construct($app) {

        $this->_app = $app;

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

        $el = new Text();

        $el->setName($name);
        $el->getLabel($label);
        $el->setValue($value);
        $el->setRequire($require);
        $el->setValidateOpts($paramValidate);

        $this->_elements[] = $el;

        return $this;

    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addSubmit($name, $value) {

        $el = new Submit();

        $el->setName($name);
        $el->setValue($value);

        $this->_elements[] = $el;

        return $this;

    }

    public function render() {

        $data = array(
            'action' => $this->getAction(),
            'method' => $this->getMethod(),
            'name' => $this->getName(),
        );

        $res = $this->renderTmpl($data, $this->getTempl());

        var_dump($res);die;


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
     * @return \System\App
     */
    public function getApp()
    {
        return $this->_app;
    }

    /**
     * @param array $data
     * @param $template
     * @return string
     */
    protected function renderTmpl($data = array(), $template) {

        return $this->getApp()->getTemplater()->render($data, $template);

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

} 