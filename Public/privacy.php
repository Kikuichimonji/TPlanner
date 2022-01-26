<?php

use Controllers\IndexController;

// Load App
require_once 'autoloader.php';
Autoloader::register();



// Start Controller : NAMESPACE\CLASSNAME
$controller = new IndexController();

// Call Controller method
$controller->privacy();
// END SCRIPT
