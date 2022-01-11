<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();

//var_dump("ddd");die();
// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\UsersController();

// Call Controller method
$id = isset($_GET["id"]) ? $_GET["id"] : null;

$controller->index($id);
// END SCRIPT
//