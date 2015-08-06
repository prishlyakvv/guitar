<?php


namespace System\Form\Validator;


class MainValidator {

    const NOT_EMPTY = 'notEmpty';
    const LENGTH_MAX = 'lengthMax';
    const LENGTH_MIN = 'lengthMin';

    protected $_error = '';

    /**
     * @param $value
     * @param $type
     * @param array $attr
     * @return bool
     */
    public function validate($value, $type, $attr = array()) {

        $this->_error = '';

        $type = $type . 'Constr';
        $result = $this->$type($value, $attr);

        if ($result === true) {
            return true;
        } elseif (is_string($result)) {
            $this->_error = $result;
            return false;
        } else {
            $this->_error = 'Невалидное значение';
            return false;
        }

    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * @param $value
     * @param array $attr
     * @return bool|string
     */
    protected function notEmptyConstr($value, $attr = array()) {

        $message = 'Значение не может быть пустым';

        if (empty($value)) {
            return isset($attr['message']) ? $attr['message'] : $message;
        }

        return true;
    }

    protected function lengthMaxConstr($value, $attr = array()) {

        if (!isset($attr['max'])) {
            return true;
        }

        $message = 'Превышен лимит значения';

        if (strlen((string) $value) > $attr['max']) {
            return isset($attr['message']) ? $attr['message'] : $message;
        }

        return true;
    }

    protected function lengthMinConstr($value, $attr = array()) {

        if (!isset($attr['min'])) {
            return true;
        }

        $message = 'Слишком маленькое значение';

        if (strlen((string) $value) < $attr['min']) {
            return isset($attr['message']) ? $attr['message'] : $message;
        }

        return true;
    }

} 