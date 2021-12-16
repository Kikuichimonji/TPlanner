<?php

// Load App

require_once 'autoloader.php';
Autoloader::register();


// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\BoardController();
$ListsController = new Controllers\ListsController();

// Call Controller method
if(!isset($_GET["list"])){
    $controller->index($_GET['id']);
}else{
    if($_GET["list"] == "undefined" or $_GET["pos"] == -1 or !$_GET["card"]){
        echo "false";
    }else{
        //var_dump($_GET);die();
        $ListsController->edit($_GET['card'],$_GET['list'],$_GET['oldList'],$_GET['pos']);
    }
}

// END SCRIPT
