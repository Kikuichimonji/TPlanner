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
    if($_GET["act"]== "submit"){ // Comming from the login form
        $controller->login($_POST);
    }else if($_GET["act"]== "logout"){ // Comming from the login form
        $controller->logout();
    }
    else{ //If the user type a random attribute in get
        $controller->index();
    }
}

// END SCRIPT
