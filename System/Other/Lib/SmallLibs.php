<?php

namespace System\Other\Lib;

class SmallLibs {

    /**
     * Все значения станут типа int
     *
     * @param $arr
     * @return array
     */
    public static function int_array($arr) {
        return array_map(function($var) {
            return is_numeric($var) ? (int) $var : 0;
        }, $arr);
    }

}
