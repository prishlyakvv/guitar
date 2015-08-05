<?php

namespace System\Form\Fields;


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


}