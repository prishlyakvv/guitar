<?php

namespace System\Lib;

//Использовал компонент для чтения *.yml файлов
//Никакой другой логики этот стороний компонент не несет для проекта
use Symfony\Component\Yaml\Parser;

class YmlParser {

    public function parse($file) {

        $yamlPS = new Parser();
        $file = '../' . $file;
        if (!file_exists($file)) {
            return array();
        }
        $content = file_get_contents($file);
        if (!$content) {
            return array();
        }
        $value = $yamlPS->parse($content);
        $value = $this->appendIncludes($value);

        return $value;
    }

    /**
     * Создание возможности инклудов конфигов yml
     * Причем подключеные конфиги могут подключать другие конфиги
     *
     * @param $arr
     * @return array
     */
    private function appendIncludes($arr) {

        if (isset($arr['import'])) {

            $newArr = $this->parse($arr['import']);
            $arr = array_replace_recursive($newArr, $arr);
            unset($arr['import']);

        }

        return $arr;

    }


}
