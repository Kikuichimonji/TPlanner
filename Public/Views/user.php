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

    <main>
        <h4>Profil de l'utilisateur : <?php echo $data['user']->getUsername(); ?></h4>
        <ul>
            <li>Username : <?= $data['user']->getUsername()?></li>
            <li>Password : <?= $data['user']->getPassword()?></li>
            <li>Email : <?= $data['user']->getMail()?></li>
            <li>Role : <?php foreach(json_decode($data['user']->getRole()) as $role){echo $role.', ';} ?></li>
            <li class="icon">Icone : <span style="background-color:<?= $data['user']->getColor(); ?>"><?=  strtoupper(substr($data['user']->getUsername(),0,2)) ?></span></li>
            <li>Date de creation du compte : <?= $data['user']->getDateCreation()?></li>
            <li>Board(s) :
            <?php 
                foreach($data['user']->getListBoards() as $board)
                {
                    echo $board->getLabel().", ";
                }
            
            ?></li>
        </ul>
    </main>

    <?php require_once 'layout/footer.php'; ?>
    <script src="<?= JS_PATH ?>/global.js"></script>
</body>
</html>
