<?php 
spl_autoload_register(function ($class) {
    $classPath = $_SERVER['DOCUMENT_ROOT'] . '/validation/class/' . $class . '.php';
    $controllerPath = $_SERVER['DOCUMENT_ROOT'] . '/validation/controller/' . $class . '.php';

    if (file_exists($classPath)) {
        require_once $classPath;
    } elseif (file_exists($controllerPath)) {
        require_once $controllerPath;
    }
});


