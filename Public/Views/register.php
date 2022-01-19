<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <title>REGISTER</title>
</head>
<body>
    <header>
        <?php require_once 'layout/header.php'; ?>
    </header>

    <main id="register">
        <h1>REGISTER</h4>
        <p>
        <?php
        if(isset($data)){
            if(isset($data["error"])){
            echo $data["error"];
            }
        }
        ?>
        </p>
        <form action="register.php?act=submit" method="post">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" <?php if(isset($data["pseudo"])){echo "value='{$data["pseudo"]}'"; } ?>>
            <label for="mail">Email</label>
            <input type="text" name="mail" id="mail" <?php if(isset($data["mail"])){echo "value='{$data["mail"]}'";} ?>>
            <br>
            <span>8 charactères minimum</span>
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <label for="password2">Confirmez le Password</label>
            <input type="password" name="password2" id="password2">
            <button type="submit">Connection</button>
            <input type="hidden" name="token" id="token" value="<?php echo $data['token']; ?>" />
        </form>
    </main>

    <?php require_once 'layout/footer.php'; ?>
    <script src="<?= JS_PATH ?>/global.js"></script>
</body>
</html>
