<?php

namespace System\Other\Console;

use System\App;

final class Console {

    private $_args = array();

    private $_helpListAll = array();

    public function setArgs($args) {
        $this->_args = $args;
    }

    public function run() {

        if (count($this->_args) == 1) {
            $this->helpList();
        } else if (count($this->_args) > 1) {
            if (isset($this->_args[0])) {
                unset($this->_args[0]);
            }
            foreach ($this->_args as $arg) {
                $this->runActionByOption($arg);
            }
        }

    }

    private function runActionByOption($arg) {

        $pluginName = '';
        $action = '';

        $arr = explode(':', $arg);
        if (count($arr) == 2 && isset($arr[0]) && isset($arr[1])) {
            $pluginName = $arr[0];
            $action = $arr[1];
            $plugins = $this->getPlugins();
            if (in_array($pluginName, array_keys($plugins))) {
                $plugin = $plugins[$pluginName];
                $console = $plugin->getConsole();

                if (method_exists($console, $action)) {
                    $console->$action();
                }

            }

        }

    }

    /**
     * Вывод справки в консоль
     */
    private function helpList() {
        foreach ($this->getPlugins() as $plugin) {
            $console = $plugin->getConsole();
            if ($console) {
                $namePl = $plugin->getName();
                echo $namePl . PHP_EOL;
                foreach ($console->getCommandList() as $elList) {
                    $this->_helpListAll[] = $elList;
                    echo "\t" . $namePl . ':' . $elList . PHP_EOL;
                }

            }
        }
    }

    private function getPlugins() {
        $app = App::getInstance();
        return $app->getPlugins();
    }

}

