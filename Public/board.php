<?php

// Load App

use Controllers\CardsController;
use Controllers\BoardsController;
use Controllers\ListsController;

require_once 'autoloader.php';
Autoloader::register();


// Start Controller : NAMESPACE\CLASSNAME
$boardController = new BoardsController();
$listsController = new ListsController();
$cardsController = new CardsController();



// Call Controller method

if(!isset($_POST["act"])){ 
    $canView = false;
    if(isset($_GET['id'])){
        $canView = $_SESSION["user"]->isCreator($_GET['id']); //check if the user have the right to access this board
        foreach($_SESSION["user"]->getInvitedBoards() as $board){
            $canView  = $_GET['id'] == $board->getId() ? true : $canView ;
        }
    }
    $canView = $_SESSION["user"]->isAdmin() ? true : $canView;
    $boardController->index($canView ? $_GET['id'] : null);
}else{

    switch($_POST["act"]){
        case "moveCard" :
            if(isset($_GET["list"]) && isset($_GET["pos"]) && isset($_GET["card"]) && isset($_GET['oldList']))
            {
                if($_GET["list"] == "undefined" or $_GET["pos"] == -1 or $_GET["card"] == "undefined" or $_GET['oldList'] == "undefined" ){
                    //var_dump($_POST);die();
                    echo "false";
                }else{
                    //var_dump($_POST);die();
                    $cardsController->editCardsPosition($_GET['card'],$_GET['list'],$_GET['oldList'],$_GET['pos'],$_GET["board"],$_POST["isArchive"]);
                }
            }else{
                echo "false";
            }
            break;
        case "moveList" :
            if(isset($_GET["list"]) && isset($_GET["listPos"]) && isset($_GET["board"])){
                if($_GET["list"] == "undefined" || $_GET["listPos"] ==-1 || $_GET["board"] == "undefined"){
                    echo "false";
                }else{
                    $listsController->editPosition($_GET['list'],$_GET['listPos'],$_GET["board"],$_POST["isArchive"]);
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
                    $cardsController->add($_GET['list'],$_POST['text'],$_GET["board"]);
                }
            }else{
                echo "false";
            }
            break;
        case "deleteCard" :
            if(isset($_GET["card"]) && isset($_GET["pos"]) && isset($_GET["list"])){
                if($_GET["card"] == "undefined" || $_GET["pos"] == -1 || $_GET["list"] == "undefined"){
                    echo "error:Un probl??me de param??tre est survenu";
                }else{
                    echo $cardsController->deleteCard($_GET["card"],$_GET["pos"],$_GET["list"],$_GET["board"]) ? "success:La carte a bien ??t?? supprim??e" : "error:Une erreur est survenu lors de la suppression";
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
                    echo $listsController->deleteList($_GET["list"],$_GET["pos"],$_GET["board"]) ? "success:La liste ?? bien ??t?? supprim??e" : "error:La liste n'as aps pu ??tre supprim??e" ;
                }
            }else{
                var_dump($_GET);
                echo "false";
            }
            break;
        case "archiveDeleteList" :
            if(isset($_GET["list"]) && isset($_GET["board"])){
                if($_GET["list"] == "undefined" || $_GET["board"] == "undefined"){
                    echo "false";
                }else{
                    echo $listsController->archiveDeleteList($_GET["list"],$_GET["board"]) ? "success:La liste ?? bien ??t?? supprim??e" : "error:La liste n'as aps pu ??tre supprim??e" ;
                }
            }else{
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
            if(isset($_POST["text"]) && isset($_GET['list']) && isset($_GET["board"])){
                if($_GET["board"] != "undefined"){
                    $listsController->updateListTitle($_GET['list'],$_POST['text'],$_GET["board"]);
                }
            }else{
                echo "false";
            }
            break;
        case "changeCard" :
            if(isset($_POST["text"]) && isset($_GET['card']) && isset($_GET["board"])){
                if($_GET["board"] != "undefined"){
                    $cardsController->updateCardTitle($_GET['card'],$_POST['text'],$_GET["board"]);
                }
            }else{
                echo "false";
            }
            break;
        case "editCardDesc" :
            if(isset($_GET["card"]) && isset($_POST['text']) && isset($_GET["board"]) && isset($_POST["color"])){
                if($_GET["board"] != "undefined"){
                    if(array_key_exists('file',$_FILES) && $_FILES['file']['error'] === 0){
                        if($_FILES['file']['size'] < 5000000){
                            if(move_uploaded_file($_FILES['file']['tmp_name'],FILE_PATH.$_FILES['file']['name'])){
                                $cardsController->editCardDesc($_GET['card'],$_POST['text'],$_GET["board"],$_POST["color"],$_FILES['file']);
                                echo "success:Ficher upload??";
                            }else{
                                echo "error:Probl??me d'upload";
                            }
                        }else{
                            echo "error:Fichier trop lourd -> ".$_FILES['file']['size'].' octets';
                        }
                    }else{
                        $cardsController->editCardDesc($_GET['card'],$_POST['text'],$_GET["board"],$_POST["color"]);
                    }
                    die();
                }else{
                    echo "false";
                }
            }else{
                echo "false";
            }
            break;
        case "deleteFile" :
            if(isset($_GET['card']) && isset($_GET["board"]) && isset($_POST["fileName"])){
                if($_GET["board"] != "undefined"){
                    $cardsController->deleteFile($_GET['card'],$_POST['fileName'],$_GET["board"]);
                }
            }else{
                echo "false";
            }
            break;
        case "invite" :
            if(isset($_POST["mail"]) && isset($_GET["board"])){
                if($_GET["board"] != "undefined"){
                    $result = $boardController->inviteUser($_GET["board"],$_POST['mail']);
                    echo $result;
                }
            }else{
                echo "false";
            }
            break;
        case "removeInvitedUser" :
            if(isset($_POST["mail"]) && isset($_GET["board"])){
                if($_GET["board"] != "undefined"){
                    $result = $boardController->removeUser($_GET["board"],$_POST['mail']);
                    echo $result;
                }
            }else{
                echo "false";
            }
            break;
        case "deleteBoard" :
            if(isset($_GET["board"])){
                if($_GET["board"] == "undefined"){
                    echo "false";
                }else{
                    $result = $boardController->deleteBoard($_GET["board"]) ;
                    echo $result ? "relocate:dashboard.php" : "error:Le tableau n'a pu ??tre supprim??" ;
                }
            }else{
                echo "false";
            }
            break;
        case "checkChange" :
            if(isset($_GET["id"]) && isset($_POST["time"])){
                if($_GET["id"] == "undefined" || $_POST["time"] == "undefined"){
                    echo "false";
                }else{
                    $result = $boardController->checkChange($_GET["id"],$_POST["time"]);
                    echo isset($result) ? null : "reload";
                }
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
