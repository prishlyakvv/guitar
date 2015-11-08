<?php

namespace System\Other\Console;

class MainPluginConsole {

    public function getCommandList() {

        $class = new \ReflectionClass(get_class($this));
        $constants = $class->getConstants();

        $result = array();
        foreach($constants as $constant => $value) {
            $prefix = "CONSOLE_";
            if(strpos($constant, $prefix) !== false) {
                if ($class->hasMethod($value . '_Help')) {
                    $result[] = $value . " \t \t " . $this->{$value . '_Help'}();
                }
            }
        }

        return $result;

    }



}

