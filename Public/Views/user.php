<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <title>Users</title>
</head>
<body>
    <header>
        <?php require_once 'layout/header.php'; ?>
    </header>

    <main id='user'>
        <h4 class="bauhaus"><?php echo e($data['user']->getUsername()); ?></h4>
        <?php
        if(isset($data)){
            if(isset($data["error"])){
            echo '<p class="error">'.$data["error"].'</p>';
            }
            if(isset($data["success"])){
                echo '<p class="success">'.$data["success"].'</p>';
                }
        }
        ?>
        <ul id="userTabs">
            <li class="active">Profil</li>
            <li>Mail</li>
            <li>Couleur</li>
            <li>Sécurité</li>
            <li>Paramètres</li>
        </ul>
        <div id="userContent">
            <div>
                <p>Votre Pseudo actuel est '<span><?= e($data['user']->getUsername()) ?></span>'</p>
                <form action="user.php" method="post">
                    <label for="pseudo">Nouveau Pseudo</label>
                    <input type="text" name="pseudo" id="pseudo">
                    <input type="submit" value="Enregistrer les modifications" class="confirmButton">
                </form>
            </div>
            <div>
                <p>Votre adresse Email actuelle est '<?= e($data['user']->getMail()) ?>'</p>
                <form action="user.php" method="post">
                    <label for="email">Nouvelle adresse email</label>
                    <input type="text" name="email" id="email">
                    <input type="submit" value="Enregistrer les modifications" class="confirmButton">
                </form>
            </div>
            <div>
                <p>Votre couleur est <span id='userColor' style='background-color:<?= $data['user']->getColor() ?>'></span></p>
                <form action="user.php" method="post">
                    <label for="color">Nouvelle couleur (Temporairement)</label>
                    <input type="color" name="color" id="color" value="<?= $data['user']->getColor() ?>">
                    <input type="submit" value="Enregistrer les modifications" class="confirmButton">
                </form>
            </div>
            <div>
                <form action="user.php" method="post">
                    <label for="password">Mot de passe actuel*</label>
                    <input type="text" name="password" id="password">
                    <label for="passwordNew">Nouveau mot de passe*</label>
                    <input type="text" name="passwordNew" id="passwordNew">
                    <label for="passwordNew2">Confirmation du nouveau mot de passe*</label>
                    <input type="text" name="passwordNew2" id="passwordNew2">
                    <input type="submit" value="Enregistrer les modifications" class="confirmButton">
                </form>
            </div>
            <div>
                <p class='smaller'>Date de creation du compte : <?= date("d/m/Y",strtotime($data['user']->getDateCreation()))?></p>
                <p>Lorsque vous supprimez votre compte, vous perdez l'accès aux services associés aux comptes TPlanner, et nous supprimons définitivement vos données personnelles. Vous disposez de 14 jours pour annuler la suppression</p>
                <input type="submit" value="Supprimer votre compte" class="confirmButton">
            </div>
        </div>
        <ul>
            <li>Board(s) :
            <?php
                $boardList = "";
                foreach($data['user']->getListBoards() as $board)
                {
                    $boardList .= "<a href='board.php?id={$board->getId()}'>".e($board->getLabel())."</a>, ";
                }
                echo $boardList == "" ? "Vous n'avez aucun tableau" : rtrim($boardList,", ");
            ?></li>
        </ul>
    </main>

    <?php require_once 'layout/footer.php'; ?>
    <script src="<?= JS_PATH ?>/global.js"></script>
    <script src="<?= JS_PATH ?>/userProfile.js"></script>
</body>
</html>
