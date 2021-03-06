<?php

namespace System\Other\Form\Fields;


abstract class MainField {

    /**
     * @var String
     */
    private $_name;


    /**
     * @var string
     */
    private $_value = '';


    /**
     * @var string
     */
    protected $_htmlTag = '';

    /**
     * @var string
     */
    protected $_error = '';

    /**
     * @return string
     */
    public function getHtmlTag()
    {
        return $this->_htmlTag;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->_error = $error;
    }


}