<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Assets/css/style.css">
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
</body>
</html>
