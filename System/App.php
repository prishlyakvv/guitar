<?php

namespace System;

use System\Router\Router;
use System\Services\Session;
use System\Template\TemplateInterface;
use System\Router\RouterInterface;
use System\Template\Twig;
use System\Lib\YmlParser;

final class App {

    const RUN_IN_CONSOLE = 'console';
    const RUN_IN_WEB = 'web';

    /**
     * @var Template\Twig
     */
    protected $_templater;

    protected $_currDir = '';

    /**
     * @var Router
     */
    protected $_router;

    protected $_console;

    protected $_url;

    protected $_config = array();

    /**
     * Флаг использования на прод.-сервере
     * @var bool
     */
    protected $_prod = false;

    protected $_response = '';

    protected $connectionDB;

    private static $_instance;

    /**
     * @var Services\Session
     */
    protected $_session;

    private $_runIn;

    private $_args = array();

    protected $plugins = array();

    private function __construct($runIn) {

        $this->_session = new Session();
        $this->_router = new Router();

        if ($runIn == App::RUN_IN_WEB) {
            $this->_templater = new Twig();
        }

        if ($runIn == App::RUN_IN_CONSOLE) {
            $this->_console = new Console();
        }

        $this->_runIn = $runIn;

        $this->loadConfig();
        $this->_currDir = __DIR__ . '/..';
        $this->installPlugins();
    }

    public static function getInstance($runIn = App::RUN_IN_WEB) {
        if (!self::$_instance) {
            self::$_instance = new self($runIn);
        }
        return self::$_instance;
    }

    /**
     * @param TemplateInterface $templater
     */
    public function setTemplater(TemplateInterface $templater){
        $this->_templater = $templater;
    }

    /**
     * @return Twig
     */
    public function getTemplater(){
        return $this->_templater;
    }

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router){
        $this->_router = $router;
    }

    /**
     * @return Router
     */
    public function getRouter(){
        return $this->_router;
    }

    /**
     * @return bool
     */
    public function isProd() {
        return $this->_prod;
    }

    /**
     * @param bool $flag
     */
    public function setProd($flag = true) {
        $this->_prod = $flag;
    }

    /**
     * Точка запуска приложения
     */
    public function run(){

        if ($this->_runIn == App::RUN_IN_WEB) {
            $url = parse_url($_SERVER["REQUEST_URI"]);
            $path = $url['path'];
            $this->_router->runAction($path);
        }

        if ($this->_runIn == App::RUN_IN_CONSOLE) {
            $this->_console->setArgs($this->_args);
            $this->_console->run();
        }

        echo $this->getResponse();
    }

    public function setArgs($_args) {
        $this->_args = $_args;
    }

    public function loadConfig() {

        $parser = new YmlParser();
        $this->_config = $parser->parse('config/app.yml');

    }

    public function getConfig() {
        return $this->_config;
    }

    public function setConfig($config) {
        $this->_config = $config;
    }

    public function getConfigParam($param) {

        if (isset($this->_config[$param])) {
            return $this->_config[$param];
        }

        throw new \Exception('Отсутствует параметр в конфиге');

    }

    /**
     * @return string
     */
    public function getResponse() {

        return $this->_response;

    }

    /**
     * @param $response
     */
    public function setResponse($response) {

        $this->_response = $response;

    }

    /**
     * @return Session
     */
    public function getSession() {
        return $this->_session;
    }

    /**
     * @return string
     */
    public function getCurrDir()
    {
        return $this->_currDir;
    }

    /**
     * @return mixed
     */
    public function getConnectionDB()
    {
        return $this->connectionDB;
    }

    /**
     * @param mixed $connectionDB
     */
    public function setConnectionDB($connectionDB)
    {
        $this->connectionDB = $connectionDB;
    }

    public function installPlugins() {

        $parser = new YmlParser();
        $plugins = $parser->parse('Plugins/plugins.yml');

        if (!isset($plugins['enable_plugins']) || !is_array($plugins['enable_plugins']) || !count($plugins['enable_plugins'])) {
            throw new \Exception('Plugins not installed');
        }

        foreach ($plugins['enable_plugins'] as $pluginPath) {

            $pluginPath .= '\Main';

            if (!file_exists(ROOT . '/../' . str_replace('\\', '/', $pluginPath . '.php'))) {
                throw new \Exception('Plugin wrong path');
            }

            $itemPlugin = new $pluginPath();
            $plaginRes = $itemPlugin->init();

            if ($plaginRes['routes']) {
                $this->getRouter()->setRoutes(array_replace_recursive($this->getRouter()->getRoutes(), $plaginRes['routes']));
            }

            if ($plaginRes['configuration']) {
                $this->setConfig(array_replace_recursive($this->getConfig(), $plaginRes['configuration']));
            }

        }
    }
}

