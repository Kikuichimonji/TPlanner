<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
  <title>Dashboard</title>
</head>
<body>
  <header>
    <?php 
      require_once 'layout/header.php'; 
      $user = $data['user'];
      //var_dump($user->getInvitedBoards());die();
    ?>
  </header>

  <main id="dashboard">
    <p>Bienvenue <?= $user->getUsername() ?></p>
    <div id="dashboardTop">
      <div><div user="<?= $user->getId() ?>"><span>+</span>Nouveau Tableau</div></div>
      <div>Trier et tout ↓</div>
    </div>
    <h2>Mes boards</h2>
    <?php 
      foreach($user->getListBoards() as $board)
      {
          echo "<span>{$board->getLabel()}</span>
          <div class='' id='{$board->getId()}'>
            <a href='board.php?id={$board->getId()}'>Voir Listes</a>
          </div>";
      }
    ?>
    <h2>Mes boards invités</h2>
    <?php  
      foreach($user->getInvitedBoards() as $board)
      {
          echo "<span>{$board->getLabel()}</span>
          <div class='' id='{$board->getId()}'>
            <a href='board.php?id={$board->getId()}'>Voir Listes</a>
          </div>";
      } ?>
  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="<?= JS_PATH ?>/dashboard.js"></script>
  <script src="<?= JS_PATH ?>/global.js"></script>
</body>
</html>
