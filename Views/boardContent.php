<main id="<?=$_GET['id'] ?>">
<?php 
    if(isset($data)){
        $user = $data['user'];
        $board = $data['board'];
    }?>
    <div id="boardHeader">
        <div id="leftside">
            <div><div><?= $board->getLabel() ?></div></div>
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
                echo "<li draggable='true' class='card' id='{$card->getId()}'><span class='cardHeader'><span>{$card->getTitle()}</span><span class='menu'>...</span></span><p class='cardBody'>{$card->getDescription()}</p></li>";
            }
            echo "</ul><span class='addCard'><span>+ Add a card</span></span></div>";
        }
    ?>
    <div id="addList"><span>+ Add a list</span><span></span></div>
    </div>
</main>
<div class="modalMenu" id="cardMenu">
    <p>Paramètres</p>
    <ul>
        <li class='update'>Modifier</li>
        <li class='move'>Déplacer</a></li>
        <li class='delete'><span class='delete'><img src='Assets/img/skull.png'></span></li>
    </ul>
</div>
<div  id="cardDetail">
    <div class="modalMenu">
        <p>Placeholder</p>
        <div>
            <div>
                <label for="cardDescription">Description</label>
                <textarea name="cardDescription" id="cardDescription" cols="30" rows="10" placeholder="Description"></textarea>
            </div>
            <ul>
                <li func='color'>Couleur de l'en-tête</li>
                <li func='tag'>étiquettes</li>
                <li func='move'>Déplacer</li>
                <li func='attribuer'>Attribuer</li>
                <li func='delete'><span class='delete'><img src='Assets/img/skull.png'></span></li>
            </ul>
        </div>
        <div>
            <button class='confirmButton'>Valider</button>
        </div>
    </div>
</div>