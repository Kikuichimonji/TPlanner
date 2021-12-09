<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();



// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\LoginController();

// Call Controller method
if(!isset($_GET["act"])){
    $controller->index();
}else{
    if($_GET["act"]== "submit"){
        $controller->login($_POST);
    }
    else{
        $controller->index();
    }
}

// END SCRIPT
