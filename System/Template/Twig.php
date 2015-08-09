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

        $configTwig = $this->getApp()->getConfigParam('twig_params');

        if (!isset($configTwig['cache_path']) || !isset($configTwig['templates_path'])) {
            throw new \Exception('Неверные Параметры конфигурации twig');
        }

        $loader = new Twig_Loader_Filesystem($configTwig['templates_path']);
        $isProd = $this->getApp()->isProd();

        $this->_environment = new Twig_Environment($loader, array(
            'cache'       => $configTwig['cache_path'],
            'auto_reload' => !$isProd,
            'debug' => !$isProd,
        ));

        if (!$isProd) {
            $this->_environment->addExtension(new \Twig_Extension_Debug());
        }

        $this->getApp()->setResponse($this->_environment->render($template, $data));

        return $this->getApp()->getResponse();

    }

} 