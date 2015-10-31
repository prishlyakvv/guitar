<?php

namespace System\Controller;

use System\App;

class MainController {

    /**
     * Можно было бы вынести в отдельный клас
     * и сделать слабую связанность.
     *
     * @var array
     */
    protected $_request = array();

    public function __construct() {
        $this->prepareRequest();
    }

    /**
     * Действия с передаваемыми значениями
     */
    protected function prepareRequest() {

        foreach ($_REQUEST as $key => $val) {
            if (is_string($val)) {
                //todo Поправить
                $val = htmlspecialchars($val);
                $this->_request[$key] = $val;
            }
        }

    }

    /**
     * @return array
     */
    public function getRequestAll() {

        return $this->_request;

    }

    /**
     * @param $param
     * @param bool $default
     * @return bool
     */
    public function getRequestParam($param, $default = false) {

        return (isset($this->_request[$param])) ? $this->_request[$param] : $default;

    }

    /**
     * @param array $data
     * @param $template
     * @return string
     */
    protected function render($data = array(), $template) {

        return App::getInstance()->getTemplater()->render($data, $template);

    }

    /**
     * @return array
     */
    protected function getNotified() {

        return App::getInstance()->getSession()->getNotified();

    }

    /**
     * @param $message
     * @return bool
     */
    protected function addNotify($message) {

        return App::getInstance()->getSession()->addNotify($message);

    }


    /**
     * @param $name
     * @param array $params
     */
    protected function redirect($name, $params = array()) {

        $path = App::getInstance()->getRouter()->getPathByName($name, $params);
        http_redirect($path);

    }

} 