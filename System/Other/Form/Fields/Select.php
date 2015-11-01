<?php

namespace System\Other\Form\Fields;


class Select extends MainField {

    protected $_htmlTag = 'select';

    /**
     * @var array
     */
    protected $_data = array();

    /**
     * @var String
     */
    private $_label;

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