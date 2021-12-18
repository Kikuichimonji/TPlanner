<?php

// Load App

require_once 'autoloader.php';
Autoloader::register();


// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\BoardController();
$ListsController = new Controllers\ListsController();

// Call Controller method
if(!isset($_GET["list"]) && !isset($_GET["listEl"])){
    $controller->index($_GET['id']);
}else{
    //var_dump($_GET);die();
    if(isset($_GET["list"]) && isset($_GET["pos"]) && isset($_GET["card"]) && isset($_GET['oldList']))
    {
        if($_GET["list"] == "undefined" or $_GET["pos"] == -1){
            echo "false";
        }else{
            $ListsController->editCards($_GET['card'],$_GET['list'],$_GET['oldList'],$_GET['pos']);
        }
    }else if(isset($_GET["listEl"]) && isset($_GET["listPos"])){
        if($_GET["listEl"] == "undefined" or $_GET["listPos"] ==-1){
            var_dump($_GET);die();
            echo "false";
        }else{
            //var_dump($_GET);die();
            $ListsController->edit($_GET['listEl'],$_GET['listPos']);
        }
        
    }
  
  
}

// END SCRIPT
