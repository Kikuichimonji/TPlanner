<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
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
        require_once 'layout/footer.php'; 
    ?>
    <script src="<?= JS_PATH ?>/scriptBoard.js"></script>
    <script src="<?= JS_PATH ?>/global.js"></script>
</body>
</html>
