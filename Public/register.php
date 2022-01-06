<?php

// Load App
require_once 'autoloader.php';
Autoloader::register();



// Start Controller : NAMESPACE\CLASSNAME
$controller = new Controllers\LoginController();

// Call Controller method
if(!isset($_GET["act"])){ //What happen when we appear on the page normaly
    $controller->showRegister();
}else{
    if($_GET["act"]== "submit"){ // Comming from the login form
        $controller->register($_POST);
    }else{ //If the user type a random attribute in get
        $controller->index();
    }
}

// END SCRIPT
