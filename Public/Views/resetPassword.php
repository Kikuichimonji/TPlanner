<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <title>FORGOT PASSWORD</title>
</head>

<body>
    <header>
        <?php require_once 'layout/header.php'; ?>
    </header>

    <main id="login">
        <h1>FORGOT PASSWORD</h1>
        <p class="error">
            <?php
            if (isset($data)) {
                if (isset($data["error"])) {
                    echo $data["error"];
                }
            }
            ?>
        </p>
        <h5>You forgot your password? We're gonna send you a new one by email.</h5>
        <form action="login.php?act=submit" method="post">
            <label for="mail">Email</label>
            <input type="text" name="mail" id="mail">
            <button type="submit">Send new password</button>
            <input type="hidden" name="token" id="token" value="<?php echo $data['token']; ?>" />
            <input type="hidden" name="reset" id="reset"/>
        </form>
    </main>

    <?php require_once 'layout/footer.php'; ?>
    <script src="<?= JS_PATH ?>/global.js"></script>
</body>

</html>