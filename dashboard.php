<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();




// Start Controller : NAMESPACE\CLASSNAME

$controller = new Controllers\DashboardController();

/*var_dump('dashboard.php');
var_dump($_SESSION);die();*/
// Call Controller method

$controller->index();
// END SCRIPT
