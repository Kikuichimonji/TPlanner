<?php

// Load App

use Controllers\CardController;
use Controllers\BoardController;
use Controllers\ListsController;

require_once 'autoloader.php';
Autoloader::register();


// Start Controller : NAMESPACE\CLASSNAME
$boardController = new BoardController();
$listsController = new ListsController();
$cardController = new CardController();


// Call Controller method

if(!isset($_GET["list"]) && !isset($_GET["listEl"])){
    $boardController->index($_GET['id']);
}else{
    
    if(isset($_GET["list"]) && isset($_GET["pos"]) && isset($_GET["card"]) && isset($_GET['oldList']))
    {
        if($_GET["list"] == "undefined" or $_GET["pos"] == -1){
            echo "false";
        }else{
            $listsController->editCards($_GET['card'],$_GET['list'],$_GET['oldList'],$_GET['pos']);
        }
    }else if(isset($_GET["listEl"]) && isset($_GET["listPos"])){
        if($_GET["listEl"] == "undefined" or $_GET["listPos"] ==-1){
            var_dump($_GET);die();
            echo "false";
        }else{
            //var_dump($_GET);die();
            $listsController->edit($_GET['listEl'],$_GET['listPos']);
        }
        
    }else if(isset($_GET["list"]) && isset($_GET["text"])){
        $cardController->add($_GET['list'],$_GET['text']);
    }else{
        echo "false";
    }
    //var_dump($_GET);die();
}

// END SCRIPT
