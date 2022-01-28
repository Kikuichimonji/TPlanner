<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <link rel="icon" type="image/svg" href="<?= IMG_PATH ?>/T_logo.svg" alt="favicon logo simplifié de TPlanner"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
  <title>Pannel Admin</title>
</head>

<body>

  <header>
    <?php require_once 'layout/header.php'; ?>
  </header>

  <main id="admin">

    <div class="admin_container">
      <div class="admin">
        </br>
        <h1>Pannel Admin</h1>
        <h2>Liste des utilisateurs (<?= count($data['users']) ?>)</h2><a href="user.php?id="></a>
        <div class='users'>
        <?php
            foreach($data['users'] as $user)
            {
              $isBanned = in_array("user",json_decode($user->getRole())) ? null : "<span class='disabled'>(disabled)</span>";
              $isAdmin = in_array("admin",json_decode($user->getRole())) ? "<span class='adminSpan'>Admin</span>" : null;
                echo "<div class='user'>
                <span class='icon'>
                  <span style='background-color:".$user->getColor()."'>".strtoupper(substr($user->getUsername(),0,2))."</span>
                </span>
                <a href='user.php?id={$user->getid()}'>{$user->getUsername()} {$isBanned} {$isAdmin}</a><span class='delete' ><a href='admin~LP9fsDOQnEuHPRbTHfn5.php?user={$user->getId()}'><img src='".IMG_PATH."/skull.png' id='{$user->getId()}'></a></span>
                </div>";
            }
        ?>
        </div>
        <h2>Listes sans Créateurs (<?= count($data['boards']) ?>)</h2><a href="user.php?id="></a>
        <div class='users'>
        <?php
            foreach($data['boards'] as $board)
            {
                echo "<div class='user'>
                <a href='board.php?id={$board->getId()}'>{$board->getLabel()}</a><span class='delete' id='{$board->getId()}'><a href='board?id={$board->getId()}'><img src='".IMG_PATH."/skull.png'></a></span>
                      </div>";
            }
        ?>
        </div>
      </div>
    </div>

  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="<?=JS_PATH ?>/globalScript.js"></script>
  <script src="<?=JS_PATH ?>/adminScript.js"></script>
</body>

</html>
