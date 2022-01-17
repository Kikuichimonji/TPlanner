<main id="<?= $_GET['id'] ?>">
    <?php
    if (isset($data)) {
        $user = $data['user'];
        $board = $data['board'];
        $isCreator = $user->isCreator($board->getId());
    } ?>
    <div id="boardHeader">
        <div id="leftside">
            <div>
                <div><?= e($board->getLabel()) ?></div>
            </div>
            <div id="listUser">
                <span class='icon'>
                    <?php
                        foreach($board->getUsersList() as $user){
                            echo "<span class='tooltip' style='background-color:" . $user->getColor() . "'>" . htmlspecialchars(strtoupper(substr($user->getUsername(), 0, 2))) . "<span class='tooltiptext'>{$user->getUsername()}<br>{$user->getMail()}</span></span>";
                        }
                    ?>
                </span>
                <div><div id="inviteButton"><span>+</span>Inviter</div></div><span id="error" class="error"></span>
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
        foreach ($board->getListLists() as $list) {
            if(!$list->getIsArchiveList() && !$list->getIsArchived()){
                echo "<div class='listContainer'><div class='listHeader' draggable='true'><span><span class='picto'></span><span class='listTitle'>".e($list->getLabel())."</span></span><span class='menu'>...</span></div>";
                echo "<ul class='list' id='{$list->getId()}'>";
                foreach ($list->getListCards() as $card) {
                    if(!$card->getIsArchived()){
                        $desc = e($card->getDescription());
                        if(strlen($desc) > 200){
                            $desc2 = substr($desc,0,200)."...";
                        }else{
                            $desc2 = $desc;
                        }
                        echo "<li draggable='true' class='card' id='{$card->getId()}'><span class='cardHeader'><span>".e($card->getTitle())."</span><span class='menu'>...</span></span><p class='cardBody' originalText='{$desc}'>{$desc2}</p></li>";
                    } 
                }
                echo "</ul><span class='addCard'><span>+ Add a card</span></span></div>";
            }
        }
        ?>
        <div id="addList"><span>+ Add a list</span><span></span></div>
        <div class="listContainer">
            <div class='listHeader'>
                <span>
                    <span class='picto'></span>
                    <span>Elements archivé</span>
                </span>
            </div>
            <?php 
                foreach ($board->getListLists() as $list) {
                    if($list->getIsArchiveList()){
                        echo "<ul class='list Archive' id='{$list->getId()}' archive>";
                        foreach($board->getCardsArchived() as $card){
                            echo "<li draggable='true' class='card' id='{$card->getId()}'><span class='cardHeader'><span>".e($card->getTitle())."</span><span class='menu'>...</span></span><p class='cardBody'>".e($card->getDescription())."</p></li>";
                        }
                        
                        foreach($board->getListsArchived() as $list){
                            echo "<div class='listContainer'>
                                    <div class='listHeader' draggable='true'>
                                        <span>
                                            <span class='picto'></span>
                                            <span>".e($list->getLabel())."</span>
                                        </span>";
                            if($isCreator){
                                echo "<span class='delete'><img src='".IMG_PATH."/skull.png'></span>";
                            }
                                    echo "<span class='menu'>...</span>
                                    </div>
                                </div>";
                        }
                        echo "</ul>";
                    }
                }
            ?>  
        </div>
        

    </div>
</main>
<div class="modalMenu" id="cardMenu">
    <p>Paramètres</p>
    <ul>
        <li func='edit'><span>Modifier</span></li>
        <li func='archive'><span>Archiver</span></li>
        <?php
            if($isCreator){
                echo "<li func='delete'><span class='delete'><img src='".IMG_PATH."/skull.png'></span></li>";
            }
        ?>
    </ul>
</div>
<div class="modalMenu" id="listMenu">
    <p>Paramètres</p>
    <ul>
        <li func='edit'><span>Modifier</span></li>
        <li func='archive'><span>Archiver</span></li>
        <?php 
            if($isCreator){
                echo "<li func='delete'><span class='delete'><img src='".IMG_PATH."/skull.png'></span></li>";
            }
        ?>
    </ul>
</div>
<div id="cardDetail">
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
                <li func='assign'>Assigner</li>
                <?php 
                    if($isCreator){
                        echo "<li func='delete'><span class='delete'><img src='".IMG_PATH."/skull.png'></span></li>";
                    }
                ?>
            </ul>
        </div>
        <div>
            <button class='confirmButton'>Valider</button>
        </div>
    </div>
</div>