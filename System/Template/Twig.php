<?php

namespace System\Template;

use Twig_Autoloader;
use Twig_Loader_Filesystem;
use Twig_Environment;

class Twig extends MainTemplate implements TemplateInterface {

    protected function setting(){
        Twig_Autoloader::register();
    }

    public function render($data, $template){

        $loader = new Twig_Loader_Filesystem('../src/Templates');
        $cacheRebuild = ! $this->getApp()->isProd();

        $this->_environment = new Twig_Environment($loader, array(
            'cache'       => '../cache/template',
            'auto_reload' => $cacheRebuild,
        ));

        $this->getApp()->setResponse($this->_environment->render($template, $data));

    }

} 