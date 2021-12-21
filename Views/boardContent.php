<main id="<?=$_GET['id'] ?>">
<?php 
    if(isset($data)){
        $user = $data['user'];
        $board = $data['board'];
    }?>
    <div id="boardHeader">
        <div id="leftside">
            <div><?= $board->getLabel() ?></div>
            <div id="listUser">
                <span class='icon'>
                    <?= "<span style='background-color:".$_SESSION['user']->getColor()."'>".strtoupper(substr($_SESSION['user']->getUsername(),0,2))."</span>" ?>
                </span>
                <div><span>+</span>Inviter</div>
            </div>
        </div>
        <div id="rightside">
            <div>Eléments archivés</div>
            <div>Filtre</div>
            <div><span>.</span><span>.</span><span>.</span></div>
        </div>
    </div>
    
    <div class='board' id='<?= $board->getId(); ?>'>
    <?php
        foreach($board->getListLists() as $list)
        {
            echo "<div class='listContainer'><div class='listHeader' draggable='true'><span><span id='picto'></span><span>{$list->getLabel()}</span></span><span class='delete'><img src='Assets/img/skull.png'></span></div>";
            echo "<ul class='list' id='{$list->getId()}'>";
            foreach($list->getListCards() as $card)
            {
                echo "<li draggable='true' class='card' id='{$card->getId()}'><span class='cardHeader'><span>{$card->getTitle()}</span><span class='delete'><img src='Assets/img/skull.png'></span></span><span>{$card->getDescription()}</span></li>";
            }
            echo "</ul><span><div>+ Add a card</div></div>";
        }
    ?>
    <div id="addList"><span>+ Add a list</span><span></span></div>
    </div>
</main>