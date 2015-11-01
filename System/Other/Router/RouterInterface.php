<?php

namespace System\Other\Router;

interface RouterInterface {

    public function runAction($url);

    public function getPathByName($name);

} 