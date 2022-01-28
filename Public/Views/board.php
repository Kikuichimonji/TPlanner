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
    <title>Dashboard</title>
</head>
<body>
    <header>
        <?php 
        
        require_once 'layout/header.php'; 
        ?>
    </header>

    <?php
        require_once 'boardContent.php';
        /*require_once 'layout/footer.php'; */
    ?>
    <script src="<?= JS_PATH ?>/boardScript.js"></script>
    <script src="<?= JS_PATH ?>/globalScript.js"></script>
</body>
</html>
