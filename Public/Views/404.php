<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <link rel="icon" type="image/svg" href="<?= IMG_PATH ?>/T_logo.svg" alt="favicon logo simplifié de N.pi" />
    <title>404</title>
</head>

<body>
    <header>
        <?php require_once 'layout/header.php'; ?>
    </header>
    <main id="404">
        <h1>404</h1>
        <h2>Désolé, cette page n'existe pas</h2>
    </main>
    <?php require_once 'layout/footer.php'; ?>
    <script src="<?= JS_PATH ?>/global.js"></script>
</body>

</html>