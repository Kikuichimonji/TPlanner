<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();


// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\UsersController();

// Call Controller method
$controller->index();
// END SCRIPT
