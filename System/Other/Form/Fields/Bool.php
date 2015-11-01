<?php

namespace System\Other\Form\Fields;


class Bool extends MainField {

    protected $_htmlTag = 'checkbox';


    /**
     * @var String
     */
    private $_label;

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