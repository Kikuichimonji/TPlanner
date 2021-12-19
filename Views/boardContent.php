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
            echo "<div class='listContainer'><div class='listHeader' draggable='true'><span>{$list->getLabel()}</span><span class='delete'><img src='Assets/img/skull.png'></span></div>";
            echo "<ul class='list' id='{$list->getId()}'>";
            foreach($list->getListCards() as $card)
            {
                echo "<li draggable='true' class='card' id='{$card->getId()}'><span class='delete'><img src='Assets/img/skull.png'></span>{$card->getTitle()}{$card->getDescription()}</li>";
            }
            echo "</ul><div>+ Add a card</div></div>";
        }
    ?>
    <div>+ Add a list</div>
    </div>
</main>