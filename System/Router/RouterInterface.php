<?php

namespace System\Router;

interface RouterInterface {

    public function runAction($url);

    public function getPathByName($name);

} 