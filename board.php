<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();


// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\BoardController();

// Call Controller method
$controller->index($_GET['id']);
// END SCRIPT
