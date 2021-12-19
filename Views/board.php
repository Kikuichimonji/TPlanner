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
    <main id="<?=$_GET['id'] ?>">
    <?php 
        if(isset($data)){
            $user = $data['user'];
            $board = $data['board'];
        }?>
        <h4>Dashboard</h4>
        <p>Bienvenue <?= $user->getUsername() ?></p>
        
        <div class='board' id='<?= $board->getId(); ?>'>       
        <?php 
        foreach($board->getListLists() as $list)
        {
            echo "<div class='listContainer'><span>{$list->getLabel()}</span>";
            echo "<ul class='list' draggable='true' id='{$list->getId()}'>";
            foreach($list->getListCards() as $card)
            {
                echo "<li draggable='true' class='card' id='{$card->getId()}'><span><img src='Assets/img/skull.png'></span>{$card->getTitle()}{$card->getDescription()}</li>";
            }
            echo "</ul><div>+ Add a card</div></div>";
        }
        ?>
        </div>
    </main>
    <?php 
        require_once 'layout/footer.php'; 
    ?>
</body>
</html>
