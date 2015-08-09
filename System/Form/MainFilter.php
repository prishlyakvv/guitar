<?php

namespace System\Form;

use System\Form\Fields\Text;
use System\Form\Fields\Select;
use System\Form\Fields\Bool;


class MainFilter {


    /**
     * @var array
     */
    private $_elements = array();
    private $_name = 'filter_';
    private $_templ = 'Form/filter.html';

    /**
     * @var \System\App
     */
    private $_app;

    /**
     * @var \System\Controller\MainController
     */
    private $_controller;

    private $_data = array();

    /**
     * @param $app
     * @param $controller
     */
    public function __construct($app, $controller) {

        $this->_app = $app;
        $this->_controller = $controller;

    }

    /**
     * Фильтр не должна иметь элименты с одним name
     *
     * @param $name
     * @throws \Exception
     */
    protected function checkName($name) {

        foreach($this->_elements as $element) {
            if ($element->getName() == $name) {
                throw new \Exception('Повторяющееся имя для элементы фильтра');
            }
        }

    }

    protected function fill() {

        $this->setData(array());
        $data = $this->_controller->getRequestAll();

        foreach ($this->getElements() as $element) {
            $elementName = $element->getName();

            if (isset($data[$elementName])) {
                $element->setValue($data[$elementName]);
                $this->addData($elementName, $data[$elementName]);
            }
        }

    }


    /**
     * @param $name
     * @param $label
     * @return $this
     */
    public function addFText($name, $label) {

        $this->checkName($name);

        $el = new Text();
        $el->setName($name);
        $el->setLabel($label);

        $this->addElement($el);

        return $this;

    }


    /**
     * @param $name
     * @param $label
     * @param $data
     * @return $this
     */
    public function addFSelect($name, $label, $data) {

        $this->checkName($name);

        $el = new Select();
        $el->setName($name);
        $el->setLabel($label);
        $el->setData($data);

        $this->addElement($el);

        return $this;

    }

    /**
     * @param $name
     * @param $label
     * @return $this
     */
    public function addFBool($name, $label) {

        $this->checkName($name);

        $el = new Bool();
        $el->setName($name);
        $el->setLabel($label);

        $this->addElement($el);

        return $this;

    }

    /**
     * @return string
     */
    public function render() {

        $data = array(
            'name' => $this->getName(),
            'fields' => $this->getElements(),
        );

        $res = $this->renderTmpl($data, $this->getTempl());

        return $res;

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

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->_elements;
    }

    /**
     * @param $element \System\Form\Fields\MainField
     */
    public function addElement($element)
    {
        $this->_elements[] = $element;
        $this->fill();
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


    public function addData($key, $value)
    {
        $this->_data[$key] = $value;
    }

} 