<?php

namespace System\Services;


class Session {

    private $_notifyNameArr = 'notify';

    /**
     * @var $_SESSION;
     */
    private $_source;

    public function __construct() {
        $this->start();
        $this->_source = &$_SESSION;

        if (!isset($this->_source[$this->_notifyNameArr])) {
            $this->_source[$this->_notifyNameArr] = array();
        }

    }

    /**
     * начало сессии
     */
    public function start() {
        session_start();
    }

    /**
     * Завершение сессии
     */
    public function destroy() {
        session_destroy();
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $this->_source[$key] = $value;
    }

    public function getByName($key) {

        return (isset($this->_source[$key])) ? $this->_source[$key] : false;

    }

    /**
     * @param $key
     */
    public function remove($key) {
        if (isset($this->_source[$key])) {
            unset($this->_source[$key]);
        }
    }

    /**
     * @return array
     */
    public function getNotified() {

        $ret = (isset($this->_source[$this->_notifyNameArr])) ? $this->_source[$this->_notifyNameArr] : array();
        $this->_source[$this->_notifyNameArr] = array();

        return $ret;

    }

    /**
     * @param $message
     * @return bool
     */
    public function addNotify($message) {

        if (!isset($this->_source[$this->_notifyNameArr])) {
            $this->_source[$this->_notifyNameArr] = array();
        }

        if (is_string($message)) {
            $this->_source[$this->_notifyNameArr][] = $message;
        }

        return true;

    }

} 