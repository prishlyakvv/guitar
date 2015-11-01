<?php

namespace System\Template;

use Twig_Autoloader;
use Twig_Loader_Filesystem;
use Twig_Environment;
use System\App;

class Twig extends MainTemplate implements TemplateInterface {

    protected function setting(){
        Twig_Autoloader::register();
    }

    public function render($data, $template){

        $configTwig = App::getInstance()->getConfigParam('twig_params');

        if (!isset($configTwig['cache_path']) || !isset($configTwig['templates_path'])) {
            throw new \Exception('Неверные Параметры конфигурации twig');
        }

        $loader = new Twig_Loader_Filesystem(ROOT . '/../' . $configTwig['templates_path']);

        /**
         * add template path plugins
         */
        foreach (App::getInstance()->getPlugins() as $plagin) {
            $loader->addPath(ROOT . '/../Plugins/' . $plagin->getName() . '/Templates');
        }

        $isProd = App::getInstance()->isProd();

        $this->_environment = new Twig_Environment($loader, array(
            'cache'       => ROOT . '/../' . $configTwig['cache_path'],
            'auto_reload' => !$isProd,
            'debug' => !$isProd,
        ));

        if (!$isProd) {
            $this->_environment->addExtension(new \Twig_Extension_Debug());
        }

        App::getInstance()->setResponse($this->_environment->render($template, $data));

        return App::getInstance()->getResponse();

    }

} 