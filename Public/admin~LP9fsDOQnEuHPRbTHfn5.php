<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();



// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\AdminController();

// Call Controller method
isset($_GET["user"]) ? $controller->deleteUser($_GET["user"]) : $controller->index();



// END SCRIPT
