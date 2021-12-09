<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();


//test
// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\WelcomeController();

// Call Controller method
$controller->index();
// END SCRIPT
