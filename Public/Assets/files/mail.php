<?php
    session_start();
    $f_prenom= trim(filter_input(INPUT_POST,"prenom",FILTER_SANITIZE_STRING));
    $f_nom= trim(filter_input(INPUT_POST,"nom",FILTER_SANITIZE_STRING)); 
    $f_message= trim(filter_input(INPUT_POST,"texte",FILTER_SANITIZE_STRING)); 
    $f_mail = trim(filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL));

    $to_email = 'thomas_roess@hotmail.fr';
    $subject = "Message portfolio de ".$f_prenom." ".$f_nom;
    $message = $f_message;
    $headers = $f_mail;

    if(mail($to_email,$subject,$message,$headers))
    {
        $now = time();
        $_SESSION["timer"] = $now;
        header("Location: index.php?m=0");
    }
    else
        header("Location: index.php?m=1");

?>