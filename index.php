<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use Controllers\IndexController;
// Load App
require_once 'autoloader.php';
Autoloader::register();


//test
// Start Controller : NAMESPACE\CLASSNAME
$controller = new IndexController();

// Call Controller method
$controller->index();
// END SCRIPT
