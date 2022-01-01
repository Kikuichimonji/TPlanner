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

if(!isset($_POST["act"])){
    if(isset($_GET['id'])){
        $boardController->index($_GET['id']);
    }else{
        $boardController->index();
    }
    
}else{

    switch($_POST["act"]){
        case "moveCard" :
            if(isset($_GET["list"]) && isset($_GET["pos"]) && isset($_GET["card"]) && isset($_GET['oldList']))
            {
                if($_GET["list"] == "undefined" or $_GET["pos"] == -1 or $_GET["card"] == "undefined" or $_GET['oldList'] == "undefined" ){
                    echo "false";
                }else{
                    $listsController->editCardsPosition($_GET['card'],$_GET['list'],$_GET['oldList'],$_GET['pos']);
                }
            }else{
                echo "false";
            }
            break;
        case "moveList" :
            if(isset($_GET["list"]) && isset($_GET["listPos"])){
                if($_GET["list"] == "undefined" || $_GET["listPos"] ==-1){
                    echo "false";
                }else{
                    $listsController->editPosition($_GET['list'],$_GET['listPos']);
                }  
            }else{
                echo "false";
            }
            break;
        case "newCard" :
            if(isset($_GET["list"]) && isset($_POST["text"])){
                if($_GET["list"] == "undefined"){
                    echo "false";
                }else{
                    //var_dump($_GET["list"]);die();
                    $cardController->add($_GET['list'],$_POST['text']);
                }
            }else{
                echo "false";
            }
            break;
        case "deleteCard" :
            if(isset($_GET["card"]) && isset($_GET["pos"]) && isset($_GET["list"])){
                if($_GET["card"] == "undefined" || $_GET["pos"] == -1 || $_GET["list"] == "undefined"){
                    echo "false";
                }else{
                    $cardController->deleteCard($_GET["card"],$_GET["pos"],$_GET["list"]);
                }
            }else{
                echo "false";
            }
            break;
        case "newList" :
            if(isset($_POST["text"]) && isset($_GET['board'])){
                    $listsController->add($_GET['board'],$_POST['text']);
            }else{
                echo "false";
            }
            break;
        case "deleteList" :
            if(isset($_GET["list"]) && isset($_GET["pos"]) && isset($_GET["board"])){
                if($_GET["list"] == "undefined" || $_GET["pos"] == -1 || $_GET["board"] == "undefined"){
                    echo "false";
                }else{
                    //var_dump($_GET);
                    $listsController->deleteList($_GET["list"],$_GET["pos"],$_GET["board"]);
                }
            }else{
                var_dump($_GET);
                echo "false";
            }
            break;
        case "changeBoard" :
            if(isset($_POST["text"]) && isset($_GET['board'])){
                $boardController->updateTitle($_GET['board'],$_POST['text']);
            }else{
                echo "false";
            }
            break;
        case "changeList" :
            if(isset($_POST["text"]) && isset($_GET['list'])){
                $listsController->updateListTitle($_GET['list'],$_POST['text']);
            }else{
                echo "false";
            }
            break;
        case "editCardDesc" :
            if(isset($_GET["card"]) && isset($_POST['text'])){
                $cardController->editCardDesc($_GET['card'],$_POST['text']);
            }else{
                echo "false";
            }
            break;
        case "reload" :
            if(isset($_GET["id"])){
                if($_GET["id"] == "undefined"){
                    echo "false";
                }else{
                    $boardController->reload($_GET["id"]);
                }
            }else{
                echo "false";
            }
            break;
        default :
            echo "Very false";
    }
    //var_dump($_GET);die();
}

// END SCRIPT
