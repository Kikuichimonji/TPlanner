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

if(!isset($_GET["act"])){
    $boardController->index($_GET['id']);
}else{

    switch($_GET["act"]){
        case "moveCard" :
            if(isset($_GET["list"]) && isset($_GET["pos"]) && isset($_GET["card"]) && isset($_GET['oldList']))
            {
                if($_GET["list"] == "undefined" or $_GET["pos"] == -1 or $_GET["card"] == "undefined" or $_GET['oldList'] == "undefined" ){
                    echo "false";
                }else{
                    $listsController->editCards($_GET['card'],$_GET['list'],$_GET['oldList'],$_GET['pos']);
                }
            }else{
                echo "false";
            }
            break;
        case "moveList" :
            if(isset($_GET["list"]) && isset($_GET["listPos"])){
                if($_GET["list"] == "undefined" or $_GET["listPos"] ==-1){
                    echo "false";
                }else{
                    $listsController->edit($_GET['list'],$_GET['listPos']);
                }  
            }else{
                echo "false";
            }
            break;
        case "newCard" :
            if(isset($_GET["list"]) && isset($_GET["text"])){
                if($_GET["list"] == "undefined"){
                    echo "false";
                }else{
                    $cardController->add($_GET['list'],$_GET['text']);
                }
            }else{
                echo "false";
            }
            break;
        default :
            echo "false";
    }
    //var_dump($_GET);die();
}

// END SCRIPT
