<?php

namespace System\Form\Fields;


abstract class MainFieldText extends MainField{

    /**
     * @var bool
     */
    private $_require = false;

    /**
     * @var array
     */
    private $_validateOpt = array();

    /**
     * @var String
     */
    private $_label;

    /**
     * @return boolean
     */
    public function getRequire()
    {
        return $this->_require;
    }

    /**
     * @param boolean $require
     */
    public function setRequire($require)
    {
        $this->_require = $require;
    }


    /**
     * @return array
     */
    public function getValidateOpt()
    {
        return $this->_validateOpt;
    }

    /**
     * @param array $validateOpts
     */
    public function setValidateOpts($validateOpts = array())
    {
        $this->_validateOpt = (array) $validateOpts;
    }

    /**
     * @param $key
     * @param $validateOpt
     */
    public function addValidateOpt($key, $validateOpt)
    {
        $this->_validateOpt[$key] = $validateOpt;
    }

    /**
     * Сброс
     */
    public function resetValidateOpt()
    {
        $this->_validateOpt = array();
    }

    /**
     * @return String
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * @param String $label
     */
    public function setLabel($label)
    {
        $this->_label = $label;
    }

}