<?php 
// require __DIR__.'../vendor/autoload.php';
require '../helpers.php';
// use Framework\Router; -> For composer install
spl_autoload_register(function($class){
    $path=basePath('Framework/'. $class.'.php');
    if(file_exists($path)){
        require $path;
    }
});

// loadView('home');
// Instanciate the router
$router = new Router();

// Get Routes
$routes = require basePath('routes.php');
// Get current URI
$uri =parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route the request
$router ->route($uri);
