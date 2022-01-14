<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
  <link rel="icon" type="image/svg" href="<?= IMG_PATH ?>/T_logo.svg" alt="favicon logo simplifié de N.pi"/>
  <title>Pannel Admin</title>
</head>

<body>

  <header>
    <?php require_once 'layout/header.php'; ?>
  </header>

  <main id="admin">

    <div class="mainheader_container">
      <div class="mainheader">
        </br>
        <h1>Pannel Admin</h1>
        <h2>Liste des utilisateurs (<?= count($data['users']) ?>)</h2><a href="user.php?id="></a>
        <?php
            foreach($data['users'] as $user)
            {
                echo "<br><a href='user.php?id={$user->getid()}'>{$user->getUsername()}</a><span class='delete'><a href='admin~LP9fsDOQnEuHPRbTHfn5.php?user={$user->getid()}'><img src='".IMG_PATH."/skull.png'></a></span>";
            }
        ?>
        <h2>Listes sans Créateurs (<?= count($data['boards']) ?>)</h2><a href="user.php?id="></a>
        <?php
            foreach($data['boards'] as $board)
            {
                echo "<br><a href=''>{$board->getLabel()}</a><span class='delete'><a href='admin~LP9fsDOQnEuHPRbTHfn5.php?board={$board->getid()}'><img src='".IMG_PATH."/skull.png'></a></span>";
            }
        ?>
      </div>
    </div>

  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="<?=JS_PATH ?>/global.js"></script>
  <script src="<?=JS_PATH ?>/admin.js"></script>
</body>

</html>
