<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <link rel="icon" type="image/svg" href="<?= IMG_PATH ?>/T_logo.svg" alt="favicon logo simplifié de TPlanner"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <title>REGISTER</title>
</head>
<body>
    <header>
        <?php require_once 'layout/header.php'; ?>
    </header>

    <main id="register">
        <h1>Inscrivez-vous sur <span class="bauhaus">TPlanner</span></h1>
        <p>
        <?php
        if(isset($data)){
            if(isset($data["error"])){
            echo '<p class="error">'.$data["error"].'</p>';
            }
        }
        ?>
        </p>

        <section class="forms_container">
        <div class="forms">
        <form action="register.php?act=submit" method="post">
        <fieldset class="fieldset_container">
            <label for="pseudo">Pseudo</label>
            <input class="input_form" type="text" name="pseudo" id="pseudo" <?php if(isset($data["pseudo"])){echo "value='{$data["pseudo"]}'"; } ?>>
            </br>
            <label for="mail">Email</label>
            <input class="input_form" type="text" name="mail" id="mail" <?php if(isset($data["mail"])){echo "value='{$data["mail"]}'";} ?>>
            </br>
            <label for="password">Password <span>(8 charactères minimum, pas de symboles)</span></label>
            <input class="input_form" type="password" name="password" id="password">
            </br>
            <label for="password2">Confirmez le Password</label>
            <input class="input_form" type="password" name="password2" id="password2">
            <p>En vous inscrivant, vous confirmez avoir lu et accepté nos conditions de service et notre politique de confidentialité.</p>
            <button type="submit">S'inscrire</button>
            <input type="hidden" name="token" id="token" value="<?php echo $data['token']; ?>" />
            </br>
            <a href='./login.php'>Vous avez déjà un compte ? Connectez-vous</a>
        </fieldset>
        </form>

    </main>

    <?php require_once 'layout/footer.php'; ?>
    <script src="<?= JS_PATH ?>/globalScript.js"></script>
</body>
</html>
