<?php

echo "hello"; die();
// Load App
require_once 'autoloader.php';
Autoloader::register();


//test
// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\IndexController();

// Call Controller method
$controller->index();
// END SCRIPT
