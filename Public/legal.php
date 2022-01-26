<?php

use Controllers\legalController;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load App
require_once 'autoloader.php';
Autoloader::register();



// Start Controller : NAMESPACE\CLASSNAME
$controller = new legalController();

// Call Controller method
$controller->legal();
// END SCRIPT
