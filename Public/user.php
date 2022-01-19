<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();

//var_dump("ddd");die();
// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\UsersController();

// Call Controller method

$id = isset($_GET["id"]) ? $_GET["id"] : null;

if(isset($_POST["pseudo"])){
    $controller->updateUsername($id,$_POST["pseudo"]);
}
if(isset($_POST["password"]) && isset($_POST["passwordNew"]) && isset($_POST["passwordNew2"])){
    $controller->updatePassword($id,$_POST["password"],$_POST["passwordNew"],$_POST["passwordNew2"]);
}
if(isset($_POST["color"])){
    $controller->updateColor($id,$_POST["color"]);
}
$controller->index($id);
// END SCRIPT
//