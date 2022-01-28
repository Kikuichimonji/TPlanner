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
    <title>FORGOT PASSWORD</title>
</head>

<body>
    <header>
        <?php require_once 'layout/header.php'; ?>
    </header>

    <main id="login">
        <h1>Réinitialisez votre mot de passe TPlanner</h1>
        <p class="error">
            <?php
            if (isset($data)) {
                if (isset($data["error"])) {
                    echo $data["error"];
                }
            }
            ?>
        </p>

        <section class="forms_container">
        <div class="forms">
        <form action="login.php?act=submit" method="post">
            <fieldset class="fieldset_container">
            <p>Vous avez oublié votre mot de passe ? Nous vous en envoyons un nouveau par mail.</p>
            <!--You forgot your password? We're gonna send you a new one by email.-->
                <label for="mail">Email</label>
                <input type="text" name="mail" id="mail">
                </br></br>
                <button type="submit">Envoyer un nouveau mot de passe</button>
                <input type="hidden" name="token" id="token" value="<?= $data['token']; ?>" />
                <input type="hidden" name="reset" id="reset"/>
            </fieldset>
        </form>
    </main>

    <?php require_once 'layout/footer.php'; ?>
    <script src="<?= JS_PATH ?>/globalScript.js"></script>
</body>

</html>