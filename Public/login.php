<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();



// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\LoginController();

// Call Controller method
if(!isset($_GET["act"])){ //What happen when we appear on the page normaly
    $controller->index();
}else{
    if($_GET["act"]== "submit"){ // Comming from the login form or reset form
        if(!isset($_POST['reset'])){
            $controller->login($_POST);
        }else{
            $controller->resetPassword($_POST['mail']);
        } 
    }else if($_GET["act"]== "logout"){ // Comming from the login form
        $controller->logout();
    }else if($_GET["act"]== "reset"){ // Comming from the login form
        $controller->showReset();
    }else{ //If the user type a random attribute in get
        $controller->index();
    }
}

// END SCRIPT
