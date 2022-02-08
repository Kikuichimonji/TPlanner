<?php
    if(!isset($data['board'])){
        echo "<h1>Le tableau à été supprimé</h1>";
        echo "<a href='dashboard.php'>Retour au dashboard</a>";
        die();
    }
    if (isset($data)) {
        $user = $data['user'];
        $board = $data['board'];
        $isCreator = $user->isCreator($board->getId());
        $isAdmin = $user->isAdmin();
    } ?>
<main id="<?= $_GET['id'] ?>" creator="<?= $isCreator ?>">
    
    <div id="lastChange"><?= $board->getLastChange() ?></div>
    <div id="boardHeader" >
        <div id="leftside">
            <div>
                <div><?= e($board->getLabel()) ?></div>
            </div>
            <div id="listUser">
                <span class='icon'>
                    <?php
                        foreach($board->getUsersList() as $user){
                            if($user->isCreator($board->getId())){
                                echo "<span id='creator' class='tooltip' style='background-color:" . $user->getColor() . "'>" . e(strtoupper(substr($user->getUsername(), 0, 2))) . "<span class='tooltiptext'>{$user->getUsername()}<br>{$user->getMail()}</span></span>";
                            }else{
                                echo "<span class='tooltip' style='background-color:" . $user->getColor() . "'>" . e(strtoupper(substr($user->getUsername(), 0, 2))) . "<span class='tooltiptext'>{$user->getUsername()}<br>{$user->getMail()}</span></span>";
                            }   
                        }
                    ?>
                </span>
                <div><div id="inviteButton">+ Inviter</div></div><span id="error" class="error"></span>
            </div>
        </div>
        <div id="rightside">
            <div>Eléments archivés</div>
            <?php
                if($isCreator || $isAdmin){
                    echo "<div class='delete'>X</div>";
                }
            ?>
        </div>
    </div>

    <div class='board' id='<?= $board->getId(); ?>'>
        <?php
        foreach ($board->getListLists() as $list) {
            if(!$list->getIsArchiveList() && !$list->getIsArchived()){
                echo "<div class='listContainer'><div class='listHeader' draggable='true'><span><img draggable='false' src='".IMG_PATH."/tplanner_picto_list1.svg' class='picto'><span class='listTitle'>".e($list->getLabel())."</span></span><span class='menu'>...</span></div>";
                echo "<ul class='list' id='{$list->getId()}'>";
                foreach ($list->getListCards() as $card) {
                    if(!$card->getIsArchived()){
                        $desc = e($card->getDescription());
                        $desc = $desc ? $desc : "";
                        if(strlen($desc) > 200){
                            $desc2 = substr($desc,0,200)."...";
                        }else{
                            $desc2 = $desc;
                        }
                        echo '<li draggable="true" class="card"  data-files=\''.$card->getFiles().'\' id="'.$card->getId().'">
                                <span class="cardHeader" style="background-color:'.$card->getColor().'">
                                    <span class="cardTitle">'.e($card->getTitle()).'</span>
                                    <span class="menu">...</span>
                                </span>
                                <span  class="cardBody" originalText="'.$desc.'"><p draggable="false">'.$desc2.'</p></span></li>';
                    } 
                }
                echo "</ul><span class='addCard'><span>+ Add a card</span></span></div>";
            }
        }
        ?>
        <div id="addList"><span>+ Add a list</span><span></span></div>
        <div class="listContainer" id="archive">
            <div class='listHeader'>
                <span>
                    <img src='<?= IMG_PATH?>/tplanner_picto_list1.svg' class='picto'>
                    <span>Elements archivé</span>
                </span>
            </div>
            <?php 
                foreach ($board->getListLists() as $list) {
                    if($list->getIsArchiveList()){
                        echo "<ul class='list Archive' id='{$list->getId()}' archive>";
                        foreach($board->getCardsArchived() as $card){
                            $desc = e($card->getDescription());
                            if(strlen($desc) > 200){
                                $desc2 = substr($desc,0,200)."...";
                            }else{
                                $desc2 = $desc;
                            }
                            echo "<li draggable='true' class='card' id='{$card->getId()}'>
                            <span class='cardHeader' style='background-color:{$card->getColor()}'>
                            <span class='cardTitle'>".e($card->getTitle())."</span><span class='menu'>...</span>
                            </span><span class='cardBody' originalText='{$desc}'><p>{$desc2}</p></span></li>";
                        }
                        
                        foreach($board->getListsArchived() as $list){
                            echo "<div class='listContainer' id={$list->getId()}>
                                    <div class='listHeader' draggable='true'>
                                        <span>
                                            <img draggable='false' src='".IMG_PATH."/tplanner_picto_list1.svg' class='picto'>
                                            <span>".e($list->getLabel())."</span>
                                        </span>";
                            if($isCreator || $isAdmin){
                                echo "<span class='delete'>X</span>";
                            }
                                    echo "<img draggable='false' src='".IMG_PATH."/tplanner_picto_unArchive.svg' class='unArchive'>
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
            if($isCreator || $isAdmin){
                echo "<li func='delete'><span class='delete'>Supprimer</span></li>";
            }
        ?>
    </ul>
</div>
<div class="modalMenu" id="listMenu">
    <p>Paramètres</p>
    <ul>
        <!--<li func='edit'><span>Modifier</span></li>-->
        <li func='archive'><span>Archiver</span></li>
        <?php 
            if($isCreator || $isAdmin){
                echo "<li func='delete'><span class='delete'>Supprimer</span></li>";
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
                <li func='color'>Couleur <input type="color"></li>
                <!--<li func='tag'>étiquettes</li>
                <li func='move'>Déplacer</li>
                <li func='assign'>Assigner</li>-->
                <?php 
                    if($isCreator || $isAdmin){
                        echo "<li func='delete' class='delete'>Supprimer</li>";
                    }
                ?>

                <li func='file'><input type="file" name="file" id="file"></li>
                
            </ul>
        </div>
        <div>
            <button class='confirmButton'>Valider</button>
        </div>
    </div>
</div>