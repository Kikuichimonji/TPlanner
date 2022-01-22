<?php

use Controllers\DashboardsController;

// Load App
require_once 'autoloader.php';
Autoloader::register();




// Start Controller : NAMESPACE\CLASSNAME

$controller = new DashboardsController();

/*var_dump('dashboard.php');
var_dump($_SESSION);die();*/
// Call Controller method

if(!isset($_POST["act"])){
    $controller->index();
}else{

    switch($_POST["act"]){
        case "newBoard" :
            if(isset($_POST["text"]) && isset($_GET["id"])){
                    echo $controller->add($_POST['text'],$_GET["id"]);
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
