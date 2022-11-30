<?php
require 'application/lib/dev.php'; // debug
use application\core\Router;
use application\lib\Db;

spl_autoload_register(function($class){ //autoload classes
    $path = str_replace('\\', '/', $class .'.php');
    if (file_exists($path)) {
        require $path;
    }
});

session_start();
$router = new Router;
$router->run();
