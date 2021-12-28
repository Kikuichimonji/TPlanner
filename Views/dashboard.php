<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./Assets/css/style.css">
  <title>Dashboard</title>
</head>
<body>
  <header>
    <?php 
      require_once 'layout/header.php'; 
      $user = $data['user']
    ?>
  </header>

  <main>
    <h4>Dashboard</h4>
    <p>Bienvenue <?= $user->getUsername() ?></p>
    <?php 
      foreach($user->getListBoards() as $board)
      {
          echo "<span>{$board->getLabel()}</span>
          <div class='' id='{$board->getId()}'>
            <a href='board.php?id={$board->getId()}'>Voir Listes</a>
          </div>";
      }
    ?>
    <?php //var_dump($user ?? []); ?>
  </main>

  <?php require_once 'layout/footer.php'; ?>
  <script src="./Assets/scripts/global.js"></script>
</body>
</html>
